<?php 
class Posts extends Controller {

    public function __construct(){
        if(!isLoggedIn()){
            redirect('users/login');
        }
        //new model instance    
        $this->postModel = $this->model('Post');
        $this->userModel = $this->model('User');
    }

    public function index(){

        $posts = $this->postModel->getPosts();
        $data = [
            'posts' => $posts
        ];

        $this->view('posts/index', $data);
    }
    public function getUser()
    {       
        if(isset($_POST['search_user'])) {
            $checkUser = $this->model->getUser($_POST['name']);
        }
    }
    //add new post 
    public function add(){
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //$img_path = URLROOT;
            $uploads_dir = '/public/img';

            $tmp_name = $_FILES["img"]["name"];
            $name = basename($_FILES["img"]["name"]);

            move_uploaded_file($tmp_name, "$uploads_dir/$name");
            
            $data = [
                'title' => trim($_POST['title']),
                //'img' => (isset($_POST['img']) ? move_uploaded_file($_POST['img']) : ''),
                'img' => trim($tmp_name),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'body_err' => '',
                'img_err' => '',
            ];

            if(empty($data['title'])){
                $data['title_err'] = 'Please enter post title';
            }


            if(empty($tmp_name)){
                $data['img_err'] = 'Please upload image';
            }
            if(empty($data['body'])){
                $data['body_err'] = 'Please enter the post content';
            }

            //validate error free
            if(empty($data['title_err']) && empty($data['body_err'])){
                if($this->postModel->addPost($data)){
                    flash('post_message', 'Your post have been added');
                    redirect('posts');
                }else{
                    die('something went wrong');
                }
               
            //load view with error
            }else{
                $this->view('posts/add', $data);
            }
        }
        else{
            $data = [
                'title' => (isset($_POST['title']) ? trim($_POST['title']) : ''),
                // 'img' => (isset($_POST['img']) ? move_uploaded_file($_POST['img']) : ''),
                'body' =>  (isset($_POST['body'])? trim($_POST['body']) : '')
            ];
            $this->view('posts/add', $data);
        }
    }

    //show single post
    public function show($id){
        
        $post = $this->postModel->getPostById($id);
        // print_r($post); exit;
        $user = $this->userModel->getUserById($post->user_id);

        $data = [
            'post' => $post,
            'user' => $user
        ];

        $this->view('posts/show', $data);
    }

    //edit post
    public function edit($id){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $uploads_dir = '/public/img';

            $tmp_name = $_FILES["img"]["name"];
            $name = basename($_FILES["img"]["name"]);

            move_uploaded_file($tmp_name, "$uploads_dir/$name");

            $oldimg = $this->postModel->getPostById($id);
        
        

            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'img' => (!empty($tmp_name)? trim($tmp_name): $oldimg->img),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'body_err' => '',
            ];
            //validate the title
            if(empty($data['title'])){
                $data['title_err'] = 'Please enter post titke';
            }
            
            //validate the image
            if(empty($tmp_name)){
                $data['img_err'] = 'Please upload image';
                
            }
            //validate the body
            if(empty($data['body'])){
                $data['body_err'] = 'Please enter the post content';
            }

            //validate error free
            if(empty($data['title_err']) && empty($_data['img_err']) && empty($data['body_err'])){
                if($this->postModel->updatePost($data)){
                    flash('post_message', 'Your post have been updated');
                    redirect('posts');
                }else{
                    die('something went wrong');
                }
               
            //load with the error
            }else{
                $this->view('posts/edit', $data);
            }
        }else{
            //check for the owner and call method from post model
            $post = $this->postModel->getPostById($id);
            if($post->user_id != $_SESSION['user_id']){
                redirect('posts');
            }
            $data = [
                'id' => $id,
                'title' => $post->title,
                'img' => $post->img,
                'body' => $post->body
            ];

            $this->view('posts/edit', $data);
        }
    }

    //delete post
    public function delete($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //check for owner
            $post = $this->postModel->getPostById($id);
            if($post->user_id != $_SESSION['user_id']){
                redirect('posts');
            }
            
            //call delete method from post
            if($this->postModel->deletePost($id)){
                flash('post_message', 'Post Removed');
                redirect('posts');
            }else{
                die('Something went wrong...!');
            }
        } else {
            redirect('posts');
        }
    }
}                            
?>                        
