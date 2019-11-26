<?php
 
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
// Output: 54esmdr0qf
// echo substr(str_shuffle($permitted_chars), 0, 10);
 
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
// Output: video-g6swmAP8X5VG4jCi.mp4
echo substr(str_shuffle($permitted_chars), 0, 8);
 
?>