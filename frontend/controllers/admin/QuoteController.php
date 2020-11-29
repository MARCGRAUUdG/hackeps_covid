<?php
namespace frontend\controllers\admin;

use frontend\filters\AdminRole;
use frontend\models\ContactForm;
use frontend\models\Quote;
use frontend\models\search\ContactFormSearch;
use frontend\models\search\QuoteSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class QuoteController extends Controller
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
        $searchModel = new QuoteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('//site/quotes/index', compact('searchModel', 'dataProvider'));
    }

    public function actionView($id)
    {
        $quote = Quote::findOne(['id' => $id]);

        if (empty($quote)) {
            throw new NotFoundHttpException("No se ha podido encontrar la consulta");
        }

        $messages = $quote->getMessages()->orderBy(['created_at' => SORT_DESC])->all();

        return $this->render('//site/quotes/view', compact('quote', 'messages'));
    }

    public function actionExpert($id)
    {
        $quote = Quote::findOne(['id' => $id]);

        if (empty($quote)) {
            throw new NotFoundHttpException("No se ha podido encontrar la consulta");
        }

        $expert = Yii::$app->request->post('expert', null);

        if (empty($expert))
        {
            Yii::$app->session->setFlash('danger', 'No se ha especificado un experto');
            return $this->redirect("/admin/consultas/{$id}");
        }

        if ($quote->status == Quote::STATUS_CREATED) {
            $quote->status = Quote::STATUS_ASSIGNED;
        }

        $quote->id_expert = $expert;
        $quote->save();

        Yii::$app->session->setFlash('success', 'Experto asignado correctamente');

        return $this->redirect("/admin/consultas/{$id}");
    }

    public function actionDelete($id)
    {
        $contact = ContactForm::findOne(['id' => $id]);

        if (empty($contact)) {
            throw new NotFoundHttpException("Registro no encontrado");
        }

        try {
            $result = $contact->delete();

            if ($result) {
                Yii::$app->session->setFlash('success', 'Registro borrado');
            }
        }

        catch (\Exception $ex) {
            Yii::$app->session->setFlash('error', "Error borrando registro: {$ex->getMessage()}");
        }

        return $this->redirect('/admin/contacto');
    }
}
