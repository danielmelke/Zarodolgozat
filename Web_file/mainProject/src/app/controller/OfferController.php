<?php

namespace app\controller;

require_once('src/app/model/User.php');
require_once('src/app/model/Offer.php');
use app\model\User;
use app\model\Offer;

class OfferController extends CommonController
{
    protected $controllerName = 'offer';

    public function actionIndex()
    {
        if (isset($_GET['order']))
        {
            $offers = Offer::findAll($_GET['order']);
        }
        else
        {
            $offers = Offer::findAll("DESC");
        }

        $this->title = "Keres-kínál hirdetések";
        
        return $this->render('index', [
            "offers" => $offers
        ]);
    }

    public function actionView($id)
    {
        $offer = Offer::findOneById($id);

        $this->title = "Hírdetés megtekintése";

        return $this->render("view", [
            "offer" => $offer
        ]);
    }

    public function actionCreate()
    {
        $this->title = 'Új hírdetés létrehozása';
        $offer = new Offer();
        if (isset($_POST['offer']) && isset($_SESSION['user_id']))
        {
            $offer->load($_POST['offer']);
            if ($offer->create()) {
                header("Location: index.php?controller=offer&action=index&create=success");
                exit();
            }
            header("Location: index.php?controller=offer&action=create&create=error");
            exit();
        }
        return $this->render('create', [
            'offer' => $offer
        ]);
    }

    public function actionUpdate($id)
    {
        $offer = Offer::findOneById($id);
        $this->title = "Hírdetés szerkesztése";
        if (isset($_POST['offer'])) 
        {
            $offer->loadUpdate($_POST['offer']);
            if ($offer->update()) 
            {
                header("Location: index.php?controller=offer&action=index&update=success");
                exit();
            }
            else
            {
                header("Location: index.php?controller=offer&action=index&update=error");
                exit();
            }
        }
        return $this->render("update", [
            "offer" => $offer
        ]);
    }

    public function actionDelete($id)
    {
        $offer = Offer::findOneById($id);
        if ($offer->getAuthor_id() == $_SESSION['user_id']) 
        {
            if ($offer->delete()) {
                header("Location: index.php?controller=offer&action=index&delete=success");
                exit();
            } else {
                header("Location: index.php?controller=offer&action=index&delete=error");
                exit();
            }
        }
    }
}