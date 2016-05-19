<?php
$relative = '../';
include($relative."includes/define.php");
include($relative."includes/connect.php");
include($relative."includes/login.php");

if(!$loggedin)
{
    header("Location: ".$relative);
}

$pagetitle = "Collection";

if(isset($_GET['filter']))
{
    $type = $_GET['filter'];
}
else
{
    $type = 'following';
}
?>


<!DOCTYPE html>

<html>
<head>
    <title><?php echo $pagetitle; ?> | <?php echo $sitename; ?></title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <?php include($relative."includes/head.php"); ?>
    <script>
        $(document).ready(function(){
            $(document).on("click", ".icons img[src='<?php echo $relative."images/like.png"; ?>']", function(){
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
            $(document).on("click", ".icons img[src='<?php echo $relative."images/liked.png"; ?>']", function(){
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
            
            
            
            // 1 = story
            // 2 = addition
            var typeReport = 0;
            
            var storyId;
            
            $(".story .icons img[src='<?php echo $relative."images/report.png"; ?>']").click(function(){
                $("#overlay").animate({
                    "left": "0"
                }, 300);
                
                storyId = $(this).parents('.story').data('storyid');
            });
            
            
            $("#reportform button[type='button']").click(function(){
                $("#overlay").animate({
                    "left": "-400%"
                }, 300);
            });
            $("#reportform").submit(function(e){
                e.preventDefault();
                

                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: {reportstory: true, title: $("#reportform input[type='text']").val(), text: $("#reportform textarea").val(), id: storyId},
                    success: function(response){
                        $("#overlay").animate({
                            "left": "-400%"
                        }, 300);
                        $("#reportform input[type='text']").val("");
                        $("#reportform textarea").val("");
                    }
                });
                
            });
            $("#sortby select").change(function(){
                $("#sortby").submit();
            });
        });
    </script>
</head>

<body>

<?php include($relative."includes/header.php");?>
<div id="container">
    <form method="get" id='sortby'>
        <select name='filter'>
            <?php
                if($type == "favorites")
                {
                    echo '<option value="favorites">Favorites</option>
                            <option value="following">Following</option>
                            <option value="likes">Likes</option>';
                }
                else if($type == "likes")
                {
                    echo '<option value="likes">Likes</option>
                            <option value="following">Following</option>
                            <option value="favorites">Favorites</option>';
                }
                else if($type == "following")
                {
                    echo '<option value="following">Following</option>
                            <option value="likes">Likes</option>
                            <option value="favorites">Favorites</option>';
                }
            ?>
        </select>
    </form>
    <div id="story">
        
        <?php
            if($type == "favorites")
                $selectstoryid = mysql_query("SELECT * FROM favorites WHERE userid=$userid ORDER BY id DESC");
            else if($type == "following")
                $selectstoryid = mysql_query("SELECT * FROM following WHERE userid=$userid ORDER BY id DESC");
            else if($type == "likes")
                $selectstoryid = mysql_query("SELECT * FROM storylikes WHERE userid=$userid ORDER BY id DESC");
                
                
            while($row2 = mysql_fetch_array($selectstoryid))
            {
                $selectstory = mysql_query("SELECT * FROM stories WHERE id=".$row2{'storyid'}." ORDER BY id DESC");
            
                while($row = mysql_fetch_array($selectstory))
                {
                    $storyid = $row{'id'};
                    if($loggedin)
                    {
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
                    
                    echo '<p class="story" data-storyid="'.$row{'id'}.'"><span id="storytitle"><a href="'.$pathtostory.$row{'storylongid'}.'">'.$row{'title'}.'</a></span>';
                    if($row{'verified'} == 1){
                        echo "<img class='icon' src='".$relative."images/verified.png' alt='mod verified story' title='Mod Verified Entry'>";
                    }
                    
                    $selectauthorinfo = mysql_query("SELECT * FROM users WHERE id='".$row{'userid'}."'");
                    while($row2 = mysql_fetch_array($selectauthorinfo))
                    {
                        $authorusername = $row2{'username'};
                        $authorname = $row2{'firstname'}." ".$row2{'lastname'};
                    }
                    $postdate = date('n/j/Y g:ia', strtotime($row{'postdate'}));
                    echo '<br><strong>'.$postdate.'</strong><br><span class="tags-list">';
                    
                    $selecttags = mysql_query("SELECT * FROM tags WHERE storyid=$storyid");
                    while($row2 = mysql_fetch_array($selecttags))
                    {
                        echo '<a href="'.$pathtotag.$row2{'tag'}.'" class="tag">'.$row2{'tag'}.'</a>';
                    }
                    
                    $text = str_split($row{'text'}, 400)[0].'&nbsp;&nbsp;<a href="'.$pathtostory.$row{'storylongid'}.'" style="color:#000;">...Continue Reading</a>';
                    
                    echo '</span><br>'.$text.'<br>
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
                        
                    }
                    echo '</span></p>';
          
                }
            }
            if(mysql_num_rows($selectstoryid) < 1)
            {
                echo "<br><h1 class='notfound'>There is nothing to show.</h1>";
            }
        ?>
       
    <br><br><br>
    
</div>
<div id="overlay"><br><br><br><br>
    <form id="reportform" class='overlayform' action="post">
        <input type="text" name="title" placeholder="Report title..."><br><br>
        <textarea name='text'></textarea><br>
        <div class='buttons'><button class='simple-button'>Report</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='simple-button'>Cancel</button></div>
    </form>
</div>
<?php include($relative."includes/footer.php"); ?>
</body>
</html>
