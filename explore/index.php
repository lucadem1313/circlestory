<?php
$relative = '../';
include($relative."includes/define.php");
include($relative."includes/connect.php");
include($relative."includes/login.php");


$pagetitle = "Explore";

if(isset($_GET['q']))
    $query = $_GET['q'];
else
    $query = "";

if(isset($_GET['sortby']))
{
    $type = $_GET['sortby'];
}
else
{
    $type = 'newest';
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
    <div id="story">
        <?php
            if($query != "")
            {
                echo "
                    <form method='get' id='search' class='searched'>
                         <input name='q' type='text' autocomplete='off'><input type='submit' value='Search'>
                    </form>
                ";
                echo '<form method="get" id="sortby">
                        <input type="hidden" name="q" value="'.$query.'">
                        <select name="sortby">';
                        if($type == "newest")
                        {
                            echo '<option value="newest">Newest</option>
                                    <option value="oldest">Oldest</option>';
                        }
                        else if($type == "oldest")
                        {
                            echo '<option value="oldest">Oldest</option>
                                    <option value="newest">Newest</option>';
                        }
                    echo'</select>
                    </form>';
                
                if($type == "newest")
                    $selectstory = mysql_query("SELECT * FROM stories WHERE title LIKE '%{$query}%' ORDER BY id DESC");
                else if($type == "oldest")
                    $selectstory = mysql_query("SELECT * FROM stories WHERE title LIKE '%{$query}%' ORDER BY id");
                    
                
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
                
                if(mysql_num_rows($selectstory) < 1)
                {
                    echo "<h1 class='notfound'>No Stories Found</h1>";
                }
            }
            else
            {
                echo "
                    <form method='get' id='search'>
                         <input name='q' type='text' autocomplete='off'><input type='submit' value='Search'>
                    </form>
                ";
            }
        ?>
    <br><br><br>
    <br><br><br>
<div id="overlay"><br><br><br><br>
    <form id="reportform" class='overlayform' action="post">
        <input type="text" name="title" placeholder="Report title..."><br><br>
        <textarea name='text'></textarea><br>
        <div class='buttons'><button class='simple-button'>Report</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='simple-button'>Cancel</button></div>
    </form>
</div>
    
</div>
</body>
</html>
