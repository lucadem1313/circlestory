<header id='topheader'>
    <h1><a href="<?php echo $relative; ?>"><img src='<?php echo $relative; ?>images/name.png' alt='logo' id='nameimage'><?php // echo $sitename; ?></a></h1>
    <nav>
        <ul>
            <?php
                $selectsubjects = mysql_query("SELECT * FROM subjects");
                while($row = mysql_fetch_array($selectsubjects))
                {
                    echo '<li><a href="'.$relative.$pathtosubject.strtolower($row{'name'}).'">'.$row{'name'}.'<div class="underline"></div></a></li>';
                }
            ?>
           <!-- <li><a href="<?php //echo $relative.$pathtosubject."horror"; ?>">Horror<div class="underline"></div></a> &nbsp;|&nbsp; </li>
            <li><a href="<?php //echo $relative.$pathtosubject."drama"; ?>">Drama<div class="underline"></div></a> &nbsp;|&nbsp; </li>
            <li><a href="<?php// echo $relative.$pathtosubject."romance"; ?>">Romance<div class="underline"></div></a> &nbsp;|&nbsp; </li>
            <li><a href="<?php// echo $relative.$pathtosubject."action"; ?>">Action<div class="underline"></div></a> &nbsp;|&nbsp; </li>
            <li><a href="<?php// echo $relative.$pathtosubject."mystery"; ?>">Mystery<div class="underline"></div></a> &nbsp;|&nbsp; </li>
            <li><a href="<?php// echo $relative.$pathtosubject."sciencefiction"; ?>">Science Fiction<div class="underline"></div></a> &nbsp;|&nbsp; </li>
            <li><a href="<?php// echo $relative.$pathtosubject."nonfiction"; ?>">Nonfiction<div class="underline"></div></a></li>-->
        </ul>
    </nav>
    <?php if($loggedin){echo '<h2 id="myaccountlink">'.$username.' <div></div></h2>'; } else { echo "<h2 id='loginlink'><a href='".$path."login'>Login</a><h2>"; } ?>
    <ul id="myaccountactionlist">
        <li><a href="<?php echo $relative; ?>">Home</a></li>
        <li><a href="<?php echo $relative."collection"; ?>">Collection</a></li>
        <li><a href="<?php echo $relative."new"; ?>">New Story</a></li>
        <li><a href="<?php echo $relative."explore"; ?>">Find Story</a></li>
        <li><a href="<?php echo $relative."user?id=".$username; ?>">Profile</a></li>
        <li><a href="<?php echo $relative."settings"; ?>">Settings</a></li>
        <li><a href="<?php echo $relative."logout"; ?>">Logout</a></li>
    </ul>
</header>