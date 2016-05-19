<?php
$relative = '../';
include($relative."includes/define.php");
include($relative."includes/connect.php");
include($relative."includes/login.php");

$storylongid = $_GET["id"];
$selectname = mysql_query("SELECT * FROM stories WHERE storylongid='".$storylongid."'") or die(mysql_error());
while($row = mysql_fetch_array($selectname))
{
    $storyname = $row{'title'};
    $storyid = $row{'id'};
    
    if($row{'userid'} == $userid)
        $mod = true;
}
$pagetitle = $storyname;
?>


<!DOCTYPE html>

<html>
<head>
    <title><?php echo $pagetitle; ?> | <?php echo $sitename; ?></title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <?php include($relative."includes/head.php"); ?>
    <script>
        $(document).ready(function(){
            $('#editor').trumbowyg({
                fullscreenable: false,
                closable: false,
                btns: ['formatting', '|', 'underline', 'bold', 'italic', '|', 'insertImage']
            });
            $("#addsubmission").submit(function(e){
                e.preventDefault();
                if($("#addsubmission input[name='anon']").is(':checked'))
                {
                    var anon = 1;
                }
                else
                {
                    var anon = 0;
                }
                //$("#story").append("<p class='prewritten story continued'><strong>Edit By:&nbsp;&nbsp; <a href='<?php echo $pathtouser.'ltdemian'; ?>'>Luca Demian</a> - 4/3/16 1:34pm</strong><br>"+$("#editor").html().replace(/<div>/g, '<br>').replace(/<\/div>/g, '')+"</p>");
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: {newaddition: $("#editor").html().replace(/<div>/g, '<br>').replace(/<\/div>/g, ''), id: "<?php echo $storyid; ?>", anonymous: anon},
                    success: function(response){
                        window.location.reload();
                    }
                });
            });
            
            
            $(document).on("click", ".prewritten .icons img[src='<?php echo $relative."images/like.png"; ?>']", function(){
                var image = $(this);
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: {likestory: true, id: $(this).parents(".story").data('storyid')},
                    success: function(response){
                        //console.log(response);
                        image.attr("src", "<?php echo $relative."images/liked.png"; ?>");
                    }
                });
            });
            $(document).on("click", ".prewritten .icons img[src='<?php echo $relative."images/liked.png"; ?>']", function(){
                var image = $(this);
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: {unlikestory: true, id: $(this).parents(".story").data('storyid')},
                    success: function(response){
                        //console.log(response);
                        image.attr("src", "<?php echo $relative."images/like.png"; ?>");
                    }
                });
            });
            
            
            
            $(document).on("click", ".prewritten img[src='<?php echo $relative."images/favorite.png"; ?>']", function(){
                var image = $(this);
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: {favorite: true, id: $(this).parents(".story").data('storyid')},
                    success: function(response){
                        //console.log(response);
                        image.attr("src", "<?php echo $relative."images/favorited.png"; ?>");
                    }
                });
            });
            $(document).on("click", ".prewritten img[src='<?php echo $relative."images/favorited.png"; ?>']", function(){
                var image = $(this);
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: {unfavorite: true, id: $(this).parents(".story").data('storyid')},
                    success: function(response){
                        //console.log(response);
                        image.attr("src", "<?php echo $relative."images/favorite.png"; ?>");
                    }
                });
            });
            
            
            $(document).on("click", ".continued .like", function(){
                var image = $(this);
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: {likeaddition: true, id: $(this).parents(".story").data('additionid')},
                    success: function(response){
                        image.attr("src", "<?php echo $relative."images/liked.png"; ?>")
                            .removeClass("like")
                            .addClass("liked");
                    }
                });
            });
            $(document).on("click", ".continued .liked", function(){
                var image = $(this);
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: {unlikeaddition: true, id: $(this).parents(".story").data('additionid')},
                    success: function(response){
                        image.attr("src", "<?php echo $relative."images/like.png"; ?>")
                            .removeClass("liked")
                            .addClass("like");
                    }
                });
            });
            
            $("#unapproved").slideUp(0);
            var oldText = $("#showhidden").text();
            var showingUnapproved = false;
            $("#showhidden").click(function(e){
                e.preventDefault();
                showingUnapproved = !showingUnapproved;
                
                $("#unapproved").slideToggle();
                if(showingUnapproved)
                    $("#showhidden").text(oldText.replace("Show", "Hide"));
                else
                    $("#showhidden").text(oldText);
                    
            });
            $("#unapproved .story").each(function(){
                $(this).children('p').slideUp();
                $(this).css("border-bottom", "2px transparent solid");
                $(this).children(".collapsebutton").text("+");
            });
            $(".collapsebutton").click(function(){
                if($(this).text() == "-")
                {
                    $(this).siblings('p').slideUp();
                    $(this).parent().css("border-bottom", "2px transparent solid");
                    $(this).text("+");
                }
                else if($(this).text() == "+")
                {
                    $(this).siblings('p').slideDown();
                    $(this).parent().css("border-bottom", "2px #000 solid");
                    $(this).text("-");
                }
            });
            
            // 1 = story
            // 2 = addition
            var typeReport = 0;
            
            var additionId;
            
            $(".prewritten .icons img[src='<?php echo $relative."images/report.png"; ?>']").click(function(){
                $("#overlay").animate({
                    "left": "0"
                }, 300);
                
                typeReport = 1;
            });
            $(".continued .icons img[src='<?php echo $relative."images/report.png"; ?>']").click(function(){
                $("#overlay").animate({
                    "left": "0"
                }, 300);
                
                typeReport = 2;
                additionId = $(this).parents('.story').data('additionid');
            });
            $("#reportform button[type='button']").click(function(){
                $("#overlay").animate({
                    "left": "-400%"
                }, 300);
            });
            $(document).on("click", "#follow", function(){
                var button = $(this);
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: {follow: true, id: $(this).parents(".story").data('storyid')},
                    success: function(response){
                        button.attr("id", "unfollow")
                                .text("Unfollow");
                    }
                });
            });
            $(document).on("click", "#unfollow", function(){
                var button = $(this);
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: {unfollow: true, id: $(this).parents(".story").data('storyid')},
                    success: function(response){
                        button.attr("id", "follow")
                                .text("Follow");
                    }
                });
            });
            $("#reportform").submit(function(e){
                e.preventDefault();
                
                if(typeReport == 1)
                {
                    $.ajax({
                        type: "POST",
                        url: "process.php",
                        data: {reportstory: true, title: $("#reportform input[type='text']").val(), text: $("#reportform textarea").val(), id: "<?php echo $storyid; ?>"},
                        success: function(response){
                            $("#overlay").animate({
                                "left": "-400%"
                            }, 300);
                            $("#reportform input[type='text']").val("");
                            $("#reportform textarea").val("");
                        }
                    });
                }
                else
                {
                    $.ajax({
                        type: "POST",
                        url: "process.php",
                        data: {reportaddition: true, title: $("#reportform input[type='text']").val(), text: $("#reportform textarea").val(), id: additionId},
                        success: function(response){
                            $("#overlay").animate({
                                "left": "-400%"
                            }, 300);
                            $("#reportform input[type='text']").val("");
                            $("#reportform textarea").val("");
                        }
                    });
                }
            });
            
            $(document).on("click", ".prewritten img[src='<?php echo $relative."images/delete.png"; ?>']", function(){
                var image = $(this);
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: {deletestory: true, id: $(this).parents(".story").data('storyid')},
                    success: function(response){
                        window.open('<?php echo $path; ?>', '_self');
                    }
                });
            });
            $(document).on("click", ".continued img[src='<?php echo $relative."images/delete.png"; ?>']", function(){
                var image = $(this);
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: {deleteaddition: true, additionid: $(this).parents(".story").data('additionid'), storyid: <?php echo $storyid; ?>},
                    success: function(response){
                        window.location.reload();
                    }
                });
            });
            $(document).on("click", ".prewritten img[src='<?php echo $relative."images/verify.png"; ?>']", function(){
                var image = $(this);
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: {verifystory: true, id: $(this).parents(".story").data('storyid')},
                    success: function(response){
                        //console.log(response);
                        image.attr("src", "<?php echo $relative."images/verified2.png"; ?>");
                    }
                });
            });
            $(document).on("click", ".prewritten img[src='<?php echo $relative."images/verified2.png"; ?>']", function(){
                var image = $(this);
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: {unverifystory: true, id: $(this).parents(".story").data('storyid')},
                    success: function(response){
                        //console.log(response);
                        image.attr("src", "<?php echo $relative."images/verify.png"; ?>");
                    }
                });
            });
            $(document).on("click", ".continued img[src='<?php echo $relative."images/verify.png"; ?>']", function(){
                var image = $(this);
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: {verifyaddition: true, additionid: $(this).parents(".story").data('additionid'), storyid: <?php echo $storyid; ?>},
                    success: function(response){
                        //console.log(response);
                        image.attr("src", "<?php echo $relative."images/verified2.png"; ?>");
                    }
                });
            });
            $(document).on("click", ".continued img[src='<?php echo $relative."images/verified2.png"; ?>']", function(){
                var image = $(this);
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: {unverifyaddition: true, additionid: $(this).parents(".story").data('additionid'), storyid: <?php echo $storyid; ?>},
                    success: function(response){
                        //console.log(response);
                        image.attr("src", "<?php echo $relative."images/verify.png"; ?>");
                    }
                });
            });
            $(document).on("click", ".continued img[src='<?php echo $relative."images/approve.png"; ?>']", function(){
                var image = $(this);
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: {approveaddition: true, additionid: $(this).parents(".story").data('additionid'), storyid: <?php echo $storyid; ?>},
                    success: function(response){
                        //console.log(response);
                        image.attr("src", "<?php echo $relative."images/approved.png"; ?>");
                    }
                });
            });
            $(document).on("click", ".continued img[src='<?php echo $relative."images/approved.png"; ?>']", function(){
                var image = $(this);
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: {unapproveaddition: true, additionid: $(this).parents(".story").data('additionid'), storyid: <?php echo $storyid; ?>},
                    success: function(response){
                        //console.log(response);
                        image.attr("src", "<?php echo $relative."images/approve.png"; ?>");
                    }
                });
            });
        });
    </script>
</head>

<body>

<?php include($relative."includes/header.php");?>
<div id="container">
    <div id="story">
        
        <?php
        
            $selectstory = mysql_query("SELECT * FROM stories WHERE id=$storyid LIMIT 1");
            while($row = mysql_fetch_array($selectstory))
            {
                if($loggedin)
                {
                    $selectfavorite = mysql_query("SELECT * FROM favorites WHERE userid=$userid AND storyid=$storyid");
                    if(mysql_num_rows($selectfavorite) > 0)
                    {
                        $userfavorited = true;
                    }
                    else
                    {
                        $userfavorited = false;
                    }
                
                    $selectlike = mysql_query("SELECT * FROM storylikes WHERE userid='$userid' AND storyid='$storyid'");
                    if(mysql_num_rows($selectlike) > 0)
                    {
                        $userliked = true;
                    }
                    else
                    {
                        $userliked = false;
                    }
                }
                
                echo '<p class="prewritten story" data-storyid="'.$row{'id'}.'"><span id="storytitle">'.$row{'title'}.'</span>';
                if($row{'verified'} == 1){
                    echo "<img class='icon' src='".$relative."images/verified.png' alt='mod verified story' title='Mod Verified Entry'>";
                }
                if($loggedin)
                {
                    echo '<img class="icon" src="';
                    if($userfavorited){
                        echo $relative."images/favorited.png\" title='Favorited'";
                    }
                    else {
                        echo $relative."images/favorite.png\" title='Favorite this post'";
                    }
                
                    echo ' alt="favorite"> - ';
                    $selectfollowing = mysql_query("SELECT * FROM following WHERE storyid=$storyid AND userid=$userid");
                    if(mysql_num_rows($selectfollowing))
                        echo '<button id="unfollow">Unfollow</button>';
                    else
                        echo '<button id="follow">Follow</button>';
                }
                $selectauthorinfo = mysql_query("SELECT * FROM users WHERE id='".$row{'userid'}."'");
                while($row2 = mysql_fetch_array($selectauthorinfo))
                {
                    $authorusername = $row2{'username'};
                    $authorname = $row2{'firstname'}." ".$row2{'lastname'};
                }
                $postdate = date('n/j/Y g:ia', strtotime($row{'postdate'}));
                echo '<br><strong>Started By:&nbsp;&nbsp; <a href="'. $pathtouser.$authorusername.'">'.$authorname.'</a> - '.$postdate.'</strong><br><span class="tags-list">';
                
                $selecttags = mysql_query("SELECT * FROM tags WHERE storyid=$storyid");
                while($row2 = mysql_fetch_array($selecttags))
                {
                    echo '<a href="'.$pathtotag.$row2{'tag'}.'" class="tag">'.$row2{'tag'}.'</a>';
                }
                
                echo '</span><br>'.$row{'text'}.'<br>
                <span class="icons">';
                
                if($loggedin)
                {
                    echo '<img src="';
                    if($userliked){
                        echo $relative."images/liked.png\" class='liked' alt='liked post'";
                    } else {
                        echo $relative."images/like.png\" class='like' alt='like post'";
                    }
                    echo '><img src="'.$relative.'images/report.png" alt="report">';
                    if($mod){
                        
                        echo '<img src="'.$path.'images/delete.png" alt="delete">';
                        if($row{'verified'} == 1){
                            echo "<img src='".$relative."images/verified2.png' alt='verified' >";
                        } else {
                            echo "<img src='".$relative."images/verify.png' alt='verify'>";
                        }
                    }
                }
                echo '</span></p>';
      
            }
        ?>
        <?php
        
            $selectstory = mysql_query("SELECT * FROM additions WHERE storyid=$storyid AND approved=1 AND draft=0 ORDER BY id DESC");
            while($row = mysql_fetch_array($selectstory))
            {
                if($loggedin)
                {
                    $selectfavorite = mysql_query("SELECT * FROM favorites WHERE userid=$userid AND storyid=$storyid");
                    if(mysql_num_rows($selectfavorite) > 0)
                    {
                        $userfavorited = true;
                    }
                    else
                    {
                        $userfavorited = false;
                    }
                
                    $selectlike = mysql_query("SELECT * FROM additionlikes WHERE userid='$userid' AND additionid='".$row{'id'}."'");
                    if(mysql_num_rows($selectlike) > 0)
                    {
                        $userliked = true;
                    }
                    else
                    {
                        $userliked = false;
                    }
                }
                
                $selectauthorinfo = mysql_query("SELECT * FROM users WHERE id='".$row{'userid'}."'");
                while($row2 = mysql_fetch_array($selectauthorinfo))
                {
                    $authorusername = $row2{'username'};
                    $authorname = $row2{'firstname'}." ".$row2{'lastname'};
                }
                
                $postdate = date('n/j/Y g:ia', strtotime($row{'postdate'}));
                
                echo '<div class="story continued" data-additionid="'.$row{'id'}.'"><button class="collapsebutton">-</button>';
                if($row{'verified'} == 1){
                    echo "<img class='icon' src='".$relative."images/verified.png' alt='mod verified story' title='Mod Verified Entry'>&nbsp;&nbsp;";
                }
                echo '<strong>Addition #'.$row{'editnumber'}.' By ';
                if($row{'anonymous'} == 0)
                    echo '<a href="'.$authorusername.'">'.$authorname.'</a> - '.$postdate.'</strong>';
                else
                    echo '<a href="">Anonymous</a> - '.$postdate.'</strong>';
                
                
                
                echo '<br><p>'.$row{'text'}.'<br>
                <span class="icons">';
                
                if($loggedin)
                {
                    echo '<img src="';
                    if($userliked){
                        echo $relative."images/liked.png\" class='liked' alt='liked post'";
                    } else {
                        echo $relative."images/like.png\" class='like' alt='like post'";
                    }
                    echo '><img src="'.$relative.'images/report.png" alt="report">';
                    if($mod){
                        if($row{'approved'} == 1){
                            echo "<img src='".$relative."images/approved.png' alt='approved'>";
                        } else {
                            echo "<img src='".$relative."images/approve.png' alt='approve'>";
                        }
                        
                        echo '<img src="'.$path.'images/delete.png" alt="delete">';
                        if($row{'verified'} == 1){
                            echo "<img src='".$relative."images/verified2.png' alt='verified' >";
                        } else {
                            echo "<img src='".$relative."images/verify.png' alt='verify'>";
                        }
                    }
                }
                echo '</span></p></div>';
            }
        ?>
    </div>
    <?php
        $selectstory = mysql_query("SELECT * FROM additions WHERE storyid=$storyid AND approved=0 AND draft=0 ORDER BY id DESC");
        
        if(mysql_num_rows($selectstory) > 0)
        {
            echo '<a href="" id="showhidden">Show '.mysql_num_rows($selectstory).' Unapproved Additions</a>';
        }
    ?>
    
    
    <div id="unapproved">
        <?php
            while($row = mysql_fetch_array($selectstory))
            {
                if($loggedin)
                {
                    $selectfavorite = mysql_query("SELECT * FROM favorites WHERE userid=$userid AND storyid=$storyid");
                    if(mysql_num_rows($selectfavorite) > 0)
                    {
                        $userfavorited = true;
                    }
                    else
                    {
                        $userfavorited = false;
                    }
                
                    $selectlike = mysql_query("SELECT * FROM additionlikes WHERE userid='$userid' AND additionid='".$row{'id'}."'");
                    if(mysql_num_rows($selectlike) > 0)
                    {
                        $userliked = true;
                    }
                    else
                    {
                        $userliked = false;
                    }
                }
                
                $selectauthorinfo = mysql_query("SELECT * FROM users WHERE id='".$row{'userid'}."'");
                while($row2 = mysql_fetch_array($selectauthorinfo))
                {
                    $authorusername = $row2{'username'};
                    $authorname = $row2{'firstname'}." ".$row2{'lastname'};
                }
                
                $postdate = date('n/j/Y g:ia', strtotime($row{'postdate'}));
                
                echo '<div class="story continued" data-additionid="'.$row{'id'}.'"><button class="collapsebutton">-</button>';
                if($row{'verified'} == 1){
                    echo "<img class='icon' src='".$relative."images/verified.png' alt='mod verified story' title='Mod Verified Entry'>&nbsp;&nbsp;";
                }
                echo '<strong>Addition #'.$row{'editnumber'}.' By ';
                if($row{'anonymous'} == 0)
                    echo '<a href="'.$authorusername.'">'.$authorname.'</a> - '.$postdate.'</strong>';
                else
                    echo '<a href="">Anonymous</a> - '.$postdate.'</strong>';
                
                
                
                echo '<br><p>'.$row{'text'}.'<br>
                <span class="icons">';
                
                if($loggedin)
                {
                    echo '<img src="';
                    if($userliked){
                        echo $relative."images/liked.png\" class='liked' alt='liked post'";
                    } else {
                        echo $relative."images/like.png\" class='like' alt='like post'";
                    }
                    echo '><img src="'.$relative.'images/report.png" alt="report">';
                    if($mod){
                        if($row{'approved'} == 1){
                            echo "<img src='".$relative."images/approved.png' alt='approved'>";
                        } else {
                            echo "<img src='".$relative."images/approve.png' alt='approve'>";
                        }
                        
                        echo '<img src="'.$path.'images/delete.png" alt="delete">';
                        if($row{'verified'} == 1){
                            echo "<img src='".$relative."images/verified2.png' alt='verified' >";
                        } else {
                            echo "<img src='".$relative."images/verify.png' alt='verify'>";
                        }
                    }
                }
                echo '</span></p></div>';
            }
        ?>
    </div>
    <br><br><br>
    <form id="addsubmission" method="post">
        <div id="editor" placeholder="Continue the story..."></div>
        <!--<button class="submit-button" type="button" id='savedraft'>Save As Draft</button>--><button class="submit-button" id='save' type="submit">Save</button><input type="checkbox" name="anon" value=1 id="checkboxanon"><label for="checkboxanon">Post Anonymously</label>
    </form>
</div>
<div id="overlay"><br><br><br><br>
    <form id="reportform" class='overlayform' action="post">
        <input type="text" name="title" placeholder="Report title..."><br><br>
        <textarea name='text'></textarea><br>
        <div class='buttons'><button class='simple-button'>Report</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='simple-button'>Cancel</button></div>
    </form>
</div>
<?php include($path."includes/footer.php"); ?>
</body>
</html>
