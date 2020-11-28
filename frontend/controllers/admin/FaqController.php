<?php
namespace frontend\controllers\admin;

use common\models\HelperFunctions;
use frontend\filters\AdminRole;
use frontend\models\Faq;
use frontend\models\FaqCategories;
use frontend\models\search\FaqSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class FaqController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AdminRole::class,
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new FaqSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', compact('searchModel', 'dataProvider'));
    }

    public function actionCreateCategory()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $title = Yii::$app->request->post('category', null);

        if (empty($title)) {
            return ['success' => false, 'message' => 'No has especificado un nombre de categoría'];
        }

        $faqCategory = new FaqCategories(['category' => $title]);
        $faqCategory->save();

        return ['success' => true, 'id' => $faqCategory->id];
    }

    public function actionCreate()
    {
        $faq = new Faq();

        if (Yii::$app->request->isPost && $faq->load(Yii::$app->request->post()))
        {
            if ($faq->validate() && $faq->save()) {
                Yii::$app->session->setFlash('success', 'Pregunta frecuente creada correctamente');
                return $this->redirect("/admin/faq/editar/{$faq->id}");
            }

            else {
                Yii::$app->session->setFlash('error', 'Error guardando la pregunta frecuente: ' . HelperFunctions::errors($faq));
            }
        }

        return $this->render('form', compact('faq'));
    }

    public function actionUpdate($id)
    {
        $faq = Faq::findOne(['id' => $id]);

        if (empty($faq)) {
            throw new NotFoundHttpException("Pregunta no encontrada");
        }

        if (Yii::$app->request->isPost && $faq->load(Yii::$app->request->post()))
        {
            if ($faq->validate() && $faq->save()) {
                Yii::$app->session->setFlash('success', 'Pregunta frecuente actualizada correctamente');
                return $this->redirect("/admin/faq");
            }

            else {
                Yii::$app->session->setFlash('error', 'Error guardando la pregunta frecuente: ' . HelperFunctions::errors($faq));
            }
        }

        return $this->render('form', compact('faq'));
    }

    public function actionDelete($id)
    {
        $faq = Faq::findOne(['id' => $id]);

        if (empty($faq)) {
            throw new NotFoundHttpException("Pregunta no encontrada");
        }

        try {
            $result = $faq->delete();

            if ($result) {
                Yii::$app->session->setFlash('success', 'Pregunta borrada');
            }
        }

        catch (\Exception $ex) {
            Yii::$app->session->setFlash('error', "Error borrando pregunta: {$ex->getMessage()}");
        }

        return $this->redirect('/admin/contacto');
    }
}
