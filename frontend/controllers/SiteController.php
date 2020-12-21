<?php
namespace frontend\controllers;

use app\models\Servers;
use common\models\HelperFunctions;
use common\models\User;
use frontend\assets\AppAsset;
use frontend\models\Center;
use frontend\models\ContactForm;
use frontend\models\Faq;
use frontend\models\FaqCategories;
use frontend\models\Provincia;
use frontend\models\Quote;
use frontend\models\QuoteMessages;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\search\QuoteSearch;
use frontend\models\VerifyEmailForm;
use http\Client;
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
use yii\web\Response;

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

    public function actionNewserver()
    {
        if (Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post('Servers');

            $salida = shell_exec("sudo VBoxManage createvm --name 1_Ubuntu --ostype Ubuntu_64 --register");
            $salida2 = shell_exec("sudo VBoxManage modifyvm 1_Ubuntu --memory 2048 --cpus 1 --vram 30 --graphicscontroller vmsvga --vrde on");
            $salida3 = shell_exec("sudo VBoxManage modifyvm 1_Ubuntu --bridgeadapter1 'wlp1s0' --nic1 bridged");
            $salida4 = shell_exec("sudo VBoxManage clonemedium disk /home/marc/Documents/BaseUbuntu.vdi /home/marc/Documents/fitxer_output.vdi --format vdi");
            $salida5 = shell_exec("sudo VBoxManage storagectl 1_Ubuntu --name 'SATA Controller' --add sata --controller IntelAhci");
            $salida6 = shell_exec("sudo VBoxManage storageattach 1_Ubuntu --storagectl 'SATA Controller' --port 0 --device 0 --type hdd --medium /home/marc/Documents/fitxer_output.vdi");

            $newSalida = explode(" ",$salida);

            $model = new Servers();
            $model->client = Yii::$app->user->id;
            $model->pla = $post['pla'];
            $model->clau = $newSalida[7];
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Servidor creat amb èxit!'.$salida);
            }

            else {
                Yii::$app->session->setFlash('error', 'Error amb el creat: ' . HelperFunctions::errors($model));
            }

            return $this->redirect('/');
        }
        return $this->render('newserver');
    }

    public function actionDeleteserver($id)
    {
        if (Yii::$app->request->isPost)
        {
            //$salida = shell_exec('pwd');
            //echo "<pre>$salida</pre>";
            //exit;

            $model = Servers::find()->where(['id' => $id])->one();
            if (!$model->delete())
            {
                Yii::$app->session->setFlash('error', 'Error eliminant el servidor: ' . HelperFunctions::errors($model));
            } else
            {
                Yii::$app->session->setFlash('success', 'Servidor eliminat amb èxit!');
            }

            return $this->redirect('/');
        }
        return $this->render('newserver');
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
     * Render the near centers.
     *
     * @return mixed
     */
    public function actionCenter()
    {
        $model = Center::find()->all();

        if (Yii::$app->request->post())
        {
            $centers = Center::find()->where(['id_provincia' => Yii::$app->request->post('Provincia')['provinciaid']] )->all();
            return $this->render('centers', ['centers' => $centers]);
        } else
        {
            return $this->render('centers', ['centers' => null]);
        }
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

        return $this->redirect(($role == User::ROLE_ADMIN ? '/admin' : '') . "/consultas/{$id}");
    }

    public function actionLocalStats()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $province = Yii::$app->request->get('province', null);

        if ($province != 0)
        {
            return [
                'total' => User::find()->where(['NOT', ['infected' => null]])->andWhere(['province' => $province])->count(),
                'infected' => User::find()->where(['infected' => 1])->andWhere(['province' => $province])->count(),
                'deaths' => User::find()->where(['infected' => 2])->andWhere(['province' => $province])->count(),
                'healed' => User::find()->where(['infected' => 3])->andWhere(['province' => $province])->count(),
            ];
        } else
        {
            return [
                'total' => User::find()->where(['NOT', ['infected' => null]])->count(),
                'infected' => User::find()->where(['infected' => 1])->count(),
                'deaths' => User::find()->where(['infected' => 2])->count(),
                'healed' => User::find()->where(['infected' => 3])->count(),
            ];
        }
    }

    public function actionOfficialStats()
    {
        $province = Yii::$app->request->get('province', null);
        $dateStart = Yii::$app->request->get('from', date('Y-m-d'));
        $dateEnd = Yii::$app->request->get('to', date('Y-m-d'));
        
        if (empty($dateStart)) {
            $dateStart = date('Y-m-d');
        }

        if (empty($dateEnd)) {
            $dateEnd = date('Y-m-d');
        }

        if (!empty($province)) {
            $province = Provincia::findOne(['provinciaid' => $province]);
        }

        if (strtotime($dateStart) >= strtotime($dateEnd)) {
            $dateEnd = $dateStart;
        }

        $dateStart = date('Y-m-d', strtotime($dateStart));
        $dateEnd = date('Y-m-d', strtotime($dateEnd));

        $client = new \yii\httpclient\Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setOptions(['timeout' => 60]);

        $withSubregion = null;

        if (empty($province)) {
            $response->setUrl("https://api.covid19tracking.narrativa.com/api/country/spain?date_from={$dateStart}&date_to={$dateEnd}");
        }

        else
        {
            $apiId = $province->api_id;

            if (strpos($apiId, '.') !== false)
            {
                $withSubregion = true;
                $region = explode('.', $apiId)[0];
                $subregion = explode('.', $apiId)[1];

                $response->setUrl("https://api.covid19tracking.narrativa.com/api/country/spain/region/{$region}/sub_region/{$subregion}?date_from={$dateStart}&date_to={$dateEnd}");
            }

            else
            {
                $withSubregion = false;
                $response->setUrl("https://api.covid19tracking.narrativa.com/api/country/spain/region/{$apiId}?date_from={$dateStart}&date_to={$dateEnd}");
            }
        }

        $response = $response->send();

        if ($response->isOk)
        {
            $infected = $deaths = $healed = 0;
            $lastUpdated = null;

            if (empty($province))
            {
                foreach ($response->data['dates'] as $date => $data)
                {
                    $infected += (int)$data['countries']['Spain']['today_new_confirmed'];
                    $deaths += (int)$data['countries']['Spain']['today_new_deaths'];
                    $healed += (int)$data['countries']['Spain']['today_new_recovered'];

                    $lastUpdated = $data['info']['date_generation'];
                }
            }

            else
            {
                foreach ($response->data['dates'] as $date => $data)
                {
                    $region = $data['countries']['Spain']['regions'][0];
                    $region = $withSubregion ? $region['sub_regions'][0] : $region;

                    $infected += (isset($region['today_new_confirmed']) ? (int)$region['today_new_confirmed'] : 0);
                    $deaths += (isset($region['today_new_deaths']) ? (int)$region['today_new_deaths'] : 0);
                    $healed += (isset($region['today_new_recovered']) ? (int)$region['today_new_recovered'] : 0);

                    $lastUpdated = $data['info']['date_generation'];
                }
            }

            Yii::$app->response->format = Response::FORMAT_JSON;

            return compact('lastUpdated', 'infected', 'deaths', 'healed');
        }

        else
        {
            return '';
        }
    }
}
