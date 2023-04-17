<?php require APPROOT . '/views/inc/header.php'; ?>
    <?php flash('post_message'); ?>
    <div class="row ">
      <div class="col-md-8">
          <h2>Posts from our blog</h2>
    </div>
      <div class="col-md-4">
          <a class="btn btn-primary pull-right" href="<?php echo URLROOT ;?>/posts/add"><i class="fa fa-pencil"></i> Add Post</a>
      </div>
  </div>
  <!--search-->
  <form action="<?php echo URLROOT; ?>/app/models/User/getUser" method="POST" class="mb20">
        <div class="row">                  
            <div class="input-wrap col-sm-12">
                <input type="text" placeholder="Search by username" value="" name="username" autocomplete="off"/>
            </div>
      </div>
        <button type="submit" class="btn btn-primary" value="Search" name="search_user">Search</button>
  </form> 
  <?php foreach ($data['posts'] as $post) : ?>
        <div class="card mb-3 mt-2">
            <div class="card-body"><h2 class="card-text"><?php echo $post->title ;?></h2>
            <p class="card-body">
                <img  height ="300px" width="500px" src="<?php __DIR__ ?>public/img/<?php  echo $post->img; ?>" alt="image" ></p></div>
                <div class="card-body"><p> 
                <?php echo  $post->body ;?>
            </p>
            <p class="card-title bg-light p-2 mb-3">
             Created By <?php echo $post->name ;?> on <?php echo  $post->postCreated ;?>
            </p>
            </div>
            <a href="<?php echo URLROOT ;?>/posts/show/<?php echo $post->postId ;?>" class="btn btn-dark btn-block">More...</a>
        </div>
        
  <?php endforeach ;?>
  <!--Pagination-->
  <nav aria-label="Page navigation">
  <ul class="pagination justify-content-center">
    <li class="page-item disabled">
      <a class="page-link" href="#" tabindex="-1">Previous</a>
    </li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item">
      <a class="page-link" href="#">Next</a>
    </li>
  </ul>
</nav>
<?php require APPROOT . '/views/inc/footer.php'; ?>