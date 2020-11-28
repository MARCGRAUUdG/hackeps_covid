<?php
namespace frontend\controllers;

use common\models\HelperFunctions;
use common\models\User;
use frontend\assets\AppAsset;
use frontend\models\ContactForm;
use frontend\models\Faq;
use frontend\models\FaqCategories;
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
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
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
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
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
            Yii::$app->session->setFlash('success', 'New password saved.');

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
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
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
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
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
}
