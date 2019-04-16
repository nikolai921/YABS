<?php


echo mktime(0, 0, 0, 03, 12, 2017);
echo '</br>';
echo time();
echo '</br>';
echo (time() - mktime(0, 0, 0, 03, 12, 2017))/20;
