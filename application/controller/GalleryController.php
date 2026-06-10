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
        $this->View->render('gallery/index', [
            'images' => GalleryModel::getOwnImages()
        ]);
    }

    public function upload()
    {
        GalleryModel::uploadImage();
        Redirect::to('gallery/index');
    }

    public function delete($id)
    {
        GalleryModel::deleteImage($id);
        Redirect::to('gallery/index');
    }

    public function show($id)
    {
        GalleryModel::showImage($id);
    }

    public function download($id)
    {
        GalleryModel::downloadImage($id);
    }

    public function share($id)
    {
        GalleryModel::shareImage($id);
        Redirect::to('gallery/index');
    }

    public function public($hash)
    {
        GalleryModel::showSharedImage($hash);
    }

    public function unshare($id)
    {
        GalleryModel::unShareImage($id);

        Redirect::to('gallery/index');
    }
}