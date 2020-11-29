<?php
namespace frontend\controllers;

use common\models\HelperFunctions;
use common\models\User;
use frontend\assets\AppAsset;
use frontend\models\ContactForm;
use frontend\models\Faq;
use frontend\models\FaqCategories;
use frontend\models\Provincia;
use frontend\models\Quote;
use frontend\models\QuoteMessages;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\search\QuoteSearch;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactFormSearch;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Link to download the app
     *
     * @return mixed
     */
    public function actionMobileApp()
    {
        return $this->render('mobile-app');
    }

    /**
     * Link to download the app
     *
     * @return mixed
     */
    public function actionEditProfile()
    {
        $model = Yii::$app->user->identity;

        if ($model->load(Yii::$app->request->post()))
        {
            $model->name = Yii::$app->request->post('User')['name'];
            $model->phone = Yii::$app->request->post('User')['phone'];
            $model->email = Yii::$app->request->post('User')['email'];
            $model->infected = Yii::$app->request->post('User')['infected'];
            $model->province = Yii::$app->request->post('User')['province'];

            if ($model->validate())
            {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Perfil actulizado con éxito!');
                }

                else {
                    Yii::$app->session->setFlash('error', 'Error con los datos introducidos: ' . HelperFunctions::errors($model));
                }

                return $this->refresh();
            }
        }
        return $this->render('edit-profile',['model' => $model]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Tu consulta se ha enviado correctamente. En breves te enviaremos una respuesta.');
            }

            else {
                Yii::$app->session->setFlash('error', 'Error con los datos del formulario: ' . HelperFunctions::errors($model));
            }

            return $this->refresh();
        }

        else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->user->login(User::findOne(['email' => Yii::$app->request->post('SignupForm')['email']]));
            Yii::$app->session->setFlash('success', 'Tu cuenta ha sido creada correctamente.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Consulta tu correo electrónico.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Se ha producido un error restableciendo la contraseña de tu cuenta.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Nueva contraseña guardada.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Cuenta activada correctamente.');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Se ha producido un error activando tu cuenta.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Comprueba tu correo electrónico.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Se ha producido un error enviando el correo de activación de tu cuenta.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    public function actionFaq()
    {
        $categories = FaqCategories::find()->all();
        $categories = ArrayHelper::map($categories, 'id', 'category');

        $faqsDb = Faq::find()->all();
        $faqs = [];

        foreach ($faqsDb as $faq)
        {
            if (!isset($faq->id_category)) {
                $faqs[$faq->id_category] = [];
            }

            $faqs[$faq->id_category][] = $faq;
        }

        return $this->render('faq', compact('faqs', 'categories'));
    }

    public function actionQuotes()
    {
        $searchModel = new QuoteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('quotes/index', compact('searchModel', 'dataProvider'));
    }

    public function actionQuote($id)
    {
        $role = Yii::$app->user->identity->role;

        $quote = null;

        if ($role == User::ROLE_EXPERT) {
            $quote = Quote::findOne(['id' => $id, 'id_expert' => Yii::$app->user->id]);
        }

        else {
            $quote = Quote::findOne(['id' => $id, 'id_user' => Yii::$app->user->id]);
        }

        if (empty($quote)) {
            throw new NotFoundHttpException("No se ha podido encontrar la consulta");
        }

        $messages = $quote->getMessages()->orderBy(['created_at' => SORT_DESC])->all();
        $newMessage = new QuoteMessages(['id_quote' => $id, 'id_user' => Yii::$app->user->id]);

        return $this->render('quotes/view', compact('quote', 'messages', 'newMessage'));
    }

    public function actionQuoteMessage($id)
    {
        $role = Yii::$app->user->identity->role;

        $quote = null;

        if ($role == User::ROLE_EXPERT) {
            $quote = Quote::findOne(['id' => $id, 'id_expert' => Yii::$app->user->id]);
        }

        else {
            $quote = Quote::findOne(['id' => $id, 'id_user' => Yii::$app->user->id]);
        }

        if (empty($quote) || $quote->status >= Quote::STATUS_SOLVED) {
            throw new NotFoundHttpException("No se ha podido encontrar la consulta");
        }

        $message = trim(Yii::$app->request->post('QuoteMessages', null)['message'] ?? null);

        if (empty($message))
        {
            Yii::$app->session->setFlash('danger', 'No se ha especificado un mensaje');
            return $this->redirect("/consultas/{$id}");
        }

        $newMessage = new QuoteMessages(['id_quote' => $id, 'id_user' => Yii::$app->user->id]);
        $newMessage->message = strip_tags($message, '<p><br>');
        $newMessage->created_at = time();
        $newMessage->save();

        Yii::$app->session->setFlash('success', 'Mensaje guardado correctamente');

        return $this->redirect("/consultas/{$id}");
    }

    public function actionQuoteStatus($id)
    {
        $role = Yii::$app->user->identity->role;

        $quote = null;

        if ($role == User::ROLE_EXPERT) {
            $quote = Quote::findOne(['id' => $id, 'id_expert' => Yii::$app->user->id]);
        }

        else if ($role == User::ROLE_ADMIN) {
            $quote = Quote::findOne(['id' => $id]);
        }

        if (empty($quote)) {
            throw new NotFoundHttpException("No se ha podido encontrar la consulta");
        }

        $status = Yii::$app->request->post('status', null);

        if ($status != 0 && empty($status))
        {
            Yii::$app->session->setFlash('danger', 'No se ha especificado un estado');
            return $this->redirect("/consultas/{$id}");
        }

        $quote->status = $status;
        $quote->save();

        Yii::$app->session->setFlash('success', 'Estado modificado correctamente');

        return $this->redirect("/consultas/{$id}");
    }

    public function actionLocalStats()
    {
        $province = Yii::$app->request->get('province', null);

        return [
            'total' => '',
            'infected' => '',
            'deaths' => '',
            'healed' => '',
        ];
    }

    public function actionOfficialStats()
    {
        $province = Yii::$app->request->get('province', null);
        $dateStart = Yii::$app->request->get('from', date('Y-m-d'));
        $dateEnd = Yii::$app->request->get('to', date('Y-m-d'));

        if (!empty($province))
        {
            $province = Provincia::findOne(['provincia' => $province]);

            if (!empty($province)) {
                $province = trim(ucfirst($province->provincia));
            }
        }

        if (strtotime($dateStart) >= strtotime($dateEnd)) {
            $dateEnd = $dateStart;
        }

        $dateStart = date('Y-d-m', strtotime($dateStart));
        $dateEnd = date('Y-d-m', strtotime($dateEnd));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if (empty($province)) {
            curl_setopt($ch, CURLOPT_URL, "https://api.covid19tracking.narrativa.com/api/country/spain?date_from={$dateStart}&date_to={$dateEnd}");
        }

        else
        {
            $apiId = $province->api_id;

            if (strpos($apiId, '.') !== false)
            {
                $region = explode('.', $apiId)[0];
                $subregion = explode('.', $apiId)[1];

                curl_setopt($ch, CURLOPT_URL, "https://api.covid19tracking.narrativa.com/api/country/spain/region/{$region}/sub_region/{$subregion}?date_from={$dateStart}&date_to={$dateEnd}");
            }

            else {
                curl_setopt($ch, CURLOPT_URL, "https://api.covid19tracking.narrativa.com/api/country/spain/region/{$apiId}?date_from={$dateStart}&date_to={$dateEnd}");
            }
        }



        $data = curl_exec($ch);
        curl_close($ch);

        print_r($data);
        exit;

        return [
            'total' => '',
            'infected' => '',
            'deaths' => '',
            'healed' => '',
        ];
    }
}
