## Description 

Take caption files and use them in ExpressionEngine templates.

Uses the [subtitles](https://github.com/mantas-done/subtitles) project.

## Parameters

| Name | Description |
| - | - |
| `file` | URL or file path to caption file. (required) |

Note that `file` should include an extension to the caption type.

## Supported formats

| Format | Extension |
| --- | --- |
| [SubRip](https://en.wikipedia.org/wiki/SubRip#SubRip_text_file_format) | .srt |
| [WebVTT](https://en.wikipedia.org/wiki/WebVTT) | .vtt |
| [Spruce Technologies SubTitles](https://pastebin.com/ykGM9qjZ) | .stl |
| [Youtube Subtitles](https://webdev-il.blogspot.lt/2010/01/sbv-file-format-for-youtube-subtitles.html) | .sbv |
| [SubViewer](https://wiki.videolan.org/SubViewer) | .sub |
| Advanced Sub Station | .ass |
| [DFXP](https://en.wikipedia.org/wiki/Timed_Text_Markup_Language) | .dfxp |
| [TTML](https://en.wikipedia.org/wiki/Timed_Text_Markup_Language) | .ttml |

SRT or VTT tend to work the best.  Some WebVTT formats may include extra metadata that might break the parsing (YouTube).  In this case try the SRT or SBV caption files.

## `render` Tags

| Name | Description |
| - | - |
| `text` | URL or file path to caption file. (required) |
| `start` | Time in seconds that the cue starts. |
| `end` |  Time in seconds that the cue ends. |
| `start_timecode` | Timecode that the cue starts in HH:MM:SS |
| `end_timecode` | Timecode that the cue end in HH:MM:SS |
| `raw` | JSON of all the cues |

Example

```html
{exp:ee_captions:render file="/files/caption.vtt"}

<li>{start_timecode} - {text}</li>

{/exp:ee_captions:render}
```
