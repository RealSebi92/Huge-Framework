<?php
class GalleryController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        Auth::checkAuthentication();
    }

    public function index() 
    {
        $this->View->render('gallery/index');
    }

    public function upload()
    {
        GalleryModel::uploadImage();
        Redirect::to('gallery/index');
    }
}