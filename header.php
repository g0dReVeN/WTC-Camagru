<div class="header">
    <div class="logo">
        <a href="index.php">
            <svg xmlns="http://www.w3.org/2000/svg"
                width="1277.000000pt" height="1280.000000pt" viewBox="0 0 1277.000000 1280.000000"
                preserveAspectRatio="xMidYMid meet">
                <g transform="translate(0.000000,1280.000000) scale(0.100000,-0.100000)" fill="#f2f2f2">
                    <path d="M6075 12794 c-893 -48 -1714 -261 -2510 -654 -649 -319 -1174 -697
                    -1695 -1219 -983 -984 -1609 -2237 -1804 -3611 -49 -341 -60 -508 -60 -910 0
                    -402 11 -568 60 -910 166 -1175 652 -2269 1415 -3186 1038 -1248 2516 -2059
                    4109 -2253 317 -38 442 -46 795 -46 480 0 835 35 1275 124 1307 265 2524 954
                    3421 1936 885 970 1439 2138 1623 3425 49 339 60 507 60 910 0 474 -27 777
                    -109 1208 -229 1218 -821 2354 -1696 3256 -670 691 -1490 1222 -2407 1557
                    -494 181 -1043 303 -1597 354 -162 15 -724 27 -880 19z m861 -479 c1021 -102
                    1915 -418 2750 -971 1309 -867 2229 -2236 2538 -3776 84 -417 110 -697 110
                    -1168 0 -390 -11 -551 -59 -877 -376 -2531 -2363 -4555 -4885 -4977 -1415
                    -237 -2837 27 -4055 752 -1443 859 -2460 2293 -2789 3934 -84 417 -110 697
                    -110 1168 0 471 27 757 110 1170 290 1434 1094 2704 2269 3584 575 431 1225
                    754 1922 955 434 125 823 190 1353 225 126 8 704 -4 846 -19z"/>
                    <path d="M6115 12070 c-1585 -73 -3069 -812 -4090 -2035 -97 -116 -295 -381
                    -295 -394 0 -11 1673 -2917 1689 -2933 3 -4 202 331 441 745 238 414 935 1620
                    1548 2681 846 1465 1111 1931 1100 1937 -15 10 -160 9 -393 -1z"/>
                    <path d="M6104 10747 c-416 -722 -799 -1384 -850 -1472 l-93 -160 3101 -3
                    c1706 -1 3103 0 3105 2 7 7 -145 263 -259 433 -753 1129 -1882 1951 -3185
                    2317 -289 81 -620 146 -893 175 -58 7 -119 13 -137 16 l-32 4 -757 -1312z"/>
                    <path d="M1533 9348 c-39 -50 -215 -379 -296 -554 -441 -952 -608 -1991 -491
                    -3039 65 -576 231 -1182 467 -1697 l36 -78 1695 0 c933 0 1696 4 1696 8 0 4
                    -105 190 -233 412 -559 969 -2784 4822 -2822 4888 -31 53 -45 69 -52 60z"/>
                    <path d="M8130 8812 c0 -5 685 -1194 1521 -2643 837 -1449 1534 -2656 1549
                    -2682 l28 -49 50 84 c178 295 375 728 491 1075 290 868 365 1805 220 2713 -75
                    470 -237 1009 -428 1423 l-40 87 -1696 0 c-932 0 -1695 -4 -1695 -8z"/>
                    <path d="M9069 5622 c-2055 -3557 -2819 -4884 -2813 -4894 8 -13 373 -3 61
                    17 710 61 1371 244 2015 560 719 353 1346 845 1859 1460 119 143 296 379 296
                    394 0 10 -1673 2916 -1689 2933 -4 4 -131 -207 -282 -470z"/>
                    <path d="M1400 3685 c0 -11 153 -265 238 -395 575 -879 1406 -1598 2350 -2035
                    451 -209 892 -349 1387 -440 134 -25 404 -62 488 -66 l48 -3 844 1463 c465
                    805 845 1467 845 1472 0 5 -1305 9 -3100 9 -1705 0 -3100 -2 -3100 -5z"/>
                </g>
            </svg>
        </a>
    </div>
    <div class="head">
        <a href="index.php">CAMAGRU</a>
    </div>
    <div class="subhead">
        <a href="mine.php">MY PIX</a>
    </div>
    <div class="subhead">
        <a href="all.php">ALL PIX</a>
    </div>
    <div class="propic">
        <div class="dropdown">
        <!-- <img  src="img/profile_image.png"> -->
            <img src='<?php echo $_SESSION['propic'];?>'>
            <!-- <img onload="if ('<?php echo $_SESSION['propic'];?>'){this.src = '<?php echo $_SESSION['propic'];?>';}" src="img/profile_image.png"> -->
            <!-- <img onload="if ('<?php echo $_SESSION['propic'];?>'){this.src = '<?php echo $_SESSION['propic'];?>';}" src="img/profile_image.png"> -->
            <!-- <img id="pic" onload="getProPic('<?php echo $_SESSION['username'];?>')" src="img/profile_image.png"> -->
        </div>
        <!-- <script> -->
            <!-- function getProPic(n) -->
            <!-- { -->
                <!-- var xhr = new XMLHttpRequest; -->
                <!-- xhr.open("GET", "getProfileData.php?username=" + n, true) -->
                <!-- xhr.send(); -->
                <!-- xhr.addEventListener("load", function() -->
                <!-- { -->
                    <!-- if (xhr.responseText) -->
                    <!-- { -->
                        <!-- var resp = (xhr.responseText.replace("\r\n", "")).split(";"); -->
                        <!-- if (resp[3]) -->
                            <!-- document.getElementById("pic").src = "data:image/png;base64," + resp[3]; -->
                    <!-- } -->
                <!-- }); -->
            <!-- } -->
        <!-- </script> -->
        <div class="dropdown-content">
            <li><a id="uname"><?php echo $_SESSION["username"];?></a></li>
            <a href="profile.php">Edit Account</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</div>