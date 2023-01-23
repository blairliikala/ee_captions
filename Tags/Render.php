<?php

namespace BlairLiikala\EeCaptions\Tags;

use ExpressionEngine\Service\Addon\Controllers\Tag\AbstractRoute;

include PATH_THIRD."/ee_captions/vendor/autoload.php";

use \Done\Subtitles\Subtitles;

class Render extends AbstractRoute
{
    // Example tag: {exp:ee_captions:render}
    public function process()
    {
        $tagdata  = ee()->TMPL->tagdata;

        // Ignore if there's no tagdata
        if (!$tagdata AND !ee()->has('coilpack'))
        {
          return '';
        }

        $file = ee()->TMPL->fetch_param('file', false);
        $type = ee()->TMPL->fetch_param('type', NULL);
        $file_id = ee()->TMPL->fetch_param('file_id', NULL);

        preg_match('/<template id="captions">(.*?)<\/template>/s', $tagdata, $text);

        if ($file_id)
        {
            $fileObj = ee('Model')->get('File', $file_id)->first();
            $file = $fileObj->getAbsolutePath();
        }
        
        if ($file)
        {
            $subtitles = Subtitles::load($file, $type);
            $subtitles_obj = $subtitles->getInternalFormat();         
        }
        else if ($text)
        {
            $subtitles = Subtitles::load($text[1], $type);
            $subtitles_obj = $subtitles->getInternalFormat();
        }
        else
        {
            return '';
        }

        $variables = array();
        foreach($subtitles_obj as $subtitle)
        {
            $variables[] = [
                'text'  => implode(" ", $subtitle['lines']),
                'start' => $subtitle['start'],
                'end'   => $subtitle['end'],
                'start_timecode' => sprintf('%02d:%02d:%02d', ($subtitle['start']/ 3600),($subtitle['start']/ 60 % 60), $subtitle['start']% 60),
                'end_timecode'   => sprintf('%02d:%02d:%02d', ($subtitle['end']/ 3600),($subtitle['end']/ 60 % 60), $subtitle['end']% 60),
                'raw'   => json_encode($subtitle, JSON_PRETTY_PRINT),
            ];
        }

        if (empty($variables))
        {
            return ''; // Render nothing in-between the tag loop.
        }

        return ee()->TMPL->parse_variables($tagdata, $variables);
    }

}
