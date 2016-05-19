<header>
    <h1><?php echo $sitename; ?></h1>
    <nav>
        <ul>
            <li><a href="<?php echo $relative.$pathtosubject."horror"; ?>">Horror<div class="underline"></div></a> &nbsp;|&nbsp; </li>
            <li><a href="<?php echo $relative.$pathtosubject."drama"; ?>">Drama<div class="underline"></div></a> &nbsp;|&nbsp; </li>
            <li><a href="<?php echo $relative.$pathtosubject."romance"; ?>">Romance<div class="underline"></div></a> &nbsp;|&nbsp; </li>
            <li><a href="<?php echo $relative.$pathtosubject."action"; ?>">Action<div class="underline"></div></a> &nbsp;|&nbsp; </li>
            <li><a href="<?php echo $relative.$pathtosubject."mystery"; ?>">Mystery<div class="underline"></div></a> &nbsp;|&nbsp; </li>
            <li><a href="<?php echo $relative.$pathtosubject."sciencefiction"; ?>">Science Fiction<div class="underline"></div></a> &nbsp;|&nbsp; </li>
            <li><a href="<?php echo $relative.$pathtosubject."nonfiction"; ?>">Nonfiction<div class="underline"></div></a></li>
        </ul>
    </nav>
    <?php if($loggedin){echo '<h2 id="myaccountlink">'.$username.' <div></div></h2>'; } else { echo "<h2 id='loginlink'><a href='".$path."login'>Login</a><h2>"; } ?>
    <ul id="myaccountactionlist">
        <li><a href="<?php echo $relative."feed"; ?>">Feed</a></li>
        <li><a href="<?php echo $relative."new"; ?>">New Story</a></li>
        <li><a href="<?php echo $relative."explore"; ?>">Find Story</a></li>
        <li><a href="<?php echo $relative."settings"; ?>">Settings</a></li>
        <li><a href="<?php echo $relative."logout"; ?>">Logout</a></li>
    </ul>
</header>