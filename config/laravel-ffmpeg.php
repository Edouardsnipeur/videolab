<?php

return [
    'default_disk' => 'local',

    'ffmpeg.binaries' => env('FFMPEG_BINARIES','C:/ffmpeg/bin/ffmpeg.exe'),
    'ffmpeg.threads'  => 12,

    'ffprobe.binaries' => env('FFPROBE_BINARIES','C:/ffmpeg/bin/ffprobe.exe'),

    'timeout' => 3600,
];
