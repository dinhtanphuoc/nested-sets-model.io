<?php
	require_once('./model.php');
		$nested = new Nested();
		// $nested->DropTable();
		// $nested->createDB();
		// $nested->createTable();
		// $parent = 2;
		// $nested->insertRight('AAAA', $parent);
		// $id = 26;
		// $parent = 21;
		// $nested->delete($id,$parent) ;
		// $id = 34;
		// $nested->remove($id);
		// $id = 2;
		// $parent = 1;
		// $brother = 3;
		// $nested->moveBefore($id,$parent,$brother);
		$id = 7;
		$parent = 3;
		// $brother = 3;
		// $nested->moveAfter($id,$parent,$brother);
		$nested->moveLeft($id,$parent);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>DEMO</title>
    <link rel="stylesheet" href="./css/style.css" />
  </head>
  <body>
 	<nav>
       DEMO
       <ul>
          <?php
            $rows = $nested->selectParent();
            while($row = $rows->fetch_assoc()){
          ?>
            <li><a href="">
               <?php echo $row['Category_name'];?> </a>
                <ul class='sub-nav'>
                  <?php
                    $rows_1 = $nested->selectParent($row['id']);
                    while($row_1 = $rows_1->fetch_assoc()){
                  ?>
                      <li><a href="">
                        <?php echo $row_1['Category_name'] ?></a>
                        <ul class ="sub-ul">
                          <?php
                            $rows_2 = $nested->selectParent($row_1['id']);
                            while($row_2 = $rows_2->fetch_assoc()) {
                          ?>
                          <li><a><?php echo $row_2['Category_name']; ?></a></li>
                          <?php
                            }
                          ?>
                        </ul>
                      </li>
                      <?php
                    }
                      ?>
                </ul>
            </li>
          <?php
        }
          ?>
       </ul>
    </nav>
    <div class="image">
       <p>AN INTRODUCTORY</p>
       <h1>Hero Banner</h1>
       <button><a href="./admin.php">ADMIN -></a></button>
    </div>
    <section>
       <article class="article-1">
           <h2>Category</h2>
           <ul>
               <li><a href="#">Example Collection</a></li>
               <li><a href="#">Example Collection</a></li>
               <li><a href="#">Example Collection</a></li>
               <li><a href="#">Example Collection</a></li>
               <li><a href="#">Example Collection</a></li>

           </ul>

           <h3>Gallery</h3>
           <div id="gallery">

           </div>
       </article>
       <article class="article-2">
           <h2>About</h2>
           <div id="about-1">

           </div>
           <div id="about-2">
               <p>Chị Hải Hà cho biết ngay sau khi tiếp nhận sự việc,
                   hiệu trưởng trường Mầm non Kitty hẹn gặp gia đình và hứa có
                   sẽ có câu trả lời thỏa đáng. Tuy nhiên, hai hôm sau,
                   chị đến làm việc với nhà trường, cô hiệu phó và hiệu trưởng
                   tỏ thái độ không hợp tác.
                   sẽ có câu trả lời thỏa đáng. Tuy nhiên, hai hôm sau,
                   chị đến làm việc với nhà trường, cô hiệu phó và hiệu trưởng
                   tỏ thái độ không hợp tác
                   sẽ có câu trả lời thỏa đáng. Tuy nhiên, hai hôm sau,
                   chị đến làm việc với nhà trường, cô hiệu phó và hiệu trưởng
                   tỏ thái độ không hợp tác

               </p>
           </div>
           <div class="clear"></div>
           <div class="list">
               <h2>Collection List</h2>
               <div class="sub-list1">
                   <a href="#">Example Collection Title</a>
               </div>
               <div class="sub-list2">
                   <a href="#">Example Collection Title</a>
               </div>
               <div class="sub-list3">
                   <a href="#">Example Collection Title</a>
               </div>
               <div class="sub-list4">
                   <a href="#">Example Collection Title</a>
               </div>
               <div class="sub-list5">
                   <a href="#">Example Collection Title</a>
               </div>
               <div class="sub-list6">
                   <a href="#">Example Collection Title</a>
               </div>
           </div>
           <div class="clear"></div>
       </article>
       <div class="clear"></div>
    </section>
    <footer>
    <p>© 2017 Shop demo</p>
    <p>Shopify</p>
    <div class="clear"></div>
    </footer>
    </body>
</html>
