<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ImagesUpload extends AbstractController
{
    private $imageFile;
    private $nomImage;

    public function insertImage($class, $form): void
    {
        $this->initImage($form, 'img');

        if($this->imageFile) {
            $this->createImageName();
            $this->moveImage();
            $class->setImg($this->nomImage);
        } else {
            throw new ErrorException("No Image found in $form $class");
        }
    }

    public function editImage($class, $form): void
    {
        $this->initImage($form, 'imageFile');
        if ($this->imageFile) {
            $this->editImageName();
            $this->moveImage();
            if ($class->getImg()) {
                unlink($this->getParameter('image_produit') . '/' . $class->getImage());
            }
            $class->setImg($this->nomImage);
        }
    }


    private function initImage($form, $img): void
    {

        $this->imageFile = $form->get($img)->getData();

    }

    private function createImageName(): void
    {
        $nomReelImage = str_replace(" ", "-", $this->imageFile->getClientOriginalName());
        $this->nomImage = date("YmdHis") . "-" . uniqid('img_', true) . "-" . $nomReelImage;
    }

    private function editImageName(): void
    {
        $this->nomImage = date('YmdHis') . "-" . uniqid('img_', false) . "-" . $this->imageFile->getClientOriginalName();
    }

    private function moveImage(): void
    {
        $this->imageFile->move(
            $this->getParameter("image_produit"),
            $this->nomImage
        );
    }
}