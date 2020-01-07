<?php
include('inc/header.php'); ?>


<div class="slideshow-container">

    <div class="mySlides fade">
        <div class="numbertext">1 / 3</div>
        <img src="asset/img/stat2.gif">
    </div>

    <div class="mySlides fade">
        <div class="numbertext">2 / 3</div>
        <img src="asset/img/stat1.jpg">
    </div>

    <div class="mySlides fade">
        <div class="numbertext">3 / 3</div>
        <img src="asset/img/stat3.jpg">
    </div>

    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>
<br>

<div style="text-align:center">
    <span class="dot" onclick="currentSlide(1)"></span>
    <span class="dot" onclick="currentSlide(2)"></span>
    <span class="dot" onclick="currentSlide(3)"></span>
</div>


<script src="asset/js/main.js"></script>