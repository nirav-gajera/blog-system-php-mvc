<?php
  class Pages extends Controller {
    public function __construct(){
     
    }
    
    public function index(){
      if(isLoggedIn()){
        redirect('posts');
      }
      $data = [
        'title' => 'Simple Blog',
        'description' => 'Blog with MVC framework',
        'info' => 'You can contact me with the following details',
        'name' => 'Nirav Gajera',
        'location' => 'Ahmedabad, Gujarat',
        'contact' => '+91 7383171393',
        'mail' => 'niravg.arsenal@gmail.com'
      ];
     
      $this->view('pages/index', $data);
    }

    public function about(){
      $data = [
        'title' => 'About Us',
        'description' => 'App to share posts with other users'
      ];

      $this->view('pages/about', $data);
    }

    public function contact(){
      $data = [
          'title' => 'Contact Us',
          'description' => 'You can contact us through this details',
          'info' => 'You can contact me with the following details for work on your project',
          'name' => 'Nirav Gajera',
          'location' => 'Ahmedabad, Gujarat',
          'contact' => '+91 7383171393',
          'mail' => 'niravg.arsenal@gmail.com'
      ];

      $this->view('pages/contact', $data);
    }
  }
?>