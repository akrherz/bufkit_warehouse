<?php
require_once "../config/settings.php";
?>
<html>

<head>

    <link rel="stylesheet" href="/css/style.css" type="text/css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/css/fb.css" />

</head>

<body>

    <div id="content" class="child-cnt" role="main">
        <div class="entry">
            <div style="width:412px; float:right;">
                <ul class="tabs">
                    <li class="fb-tab"><a href="#tab1"><span>Facebook</span></a></li>
                </ul>
                <div class="tab_container">
                    <div id="tab1" class="tab_content">
                        <div class="fb_group">
                            <a href='https://facebook.com/profile.php?id=<?php echo $group_id;  ?>&ap=1'>Facebook Profile</a>
                        </div>

            
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>