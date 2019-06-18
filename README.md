Kontollarte DOCS
================

A project made by Iván Miranda Stavenuiter. 2019.

### LINKS

Kontollarte app: www.kontollarte.com

Kontollarte docs: www.kontollarte.com/documentacion

### 1. Introducción

El siguiente proyecto consiste en una aplicación que tiene como objetivo gestionar obras de arte, ofrecer información adicional sobre eventos y galerías y, en última instancia, comercializar las creaciones del usuario a través de la plataforma Ebay.

Dicho proyecto se basa en una versión previa realizada con php nativo y modelo MVC y pretende mejorar y optimizar el funcionamiento de este modelo inicial. Las diferencias con respecto a esta primera versión son notables: se ha modificado por completo el diseño css y la estructura html, además de reelaborar toda la lógica mediante Laravel. Esto ha permitido introducir numerosas mejoras a distintos niveles: optimización de las consultas a bases de datos, seguridad adicional para las rutas de entrada a la app, validaciones más robustas y una mayor modularización del código.

#### 1\. 1. Rutas principales

Dentro de la estructura de proyecto que presenta Laravel hay algunas rutas más usadas que otras. Se definen , a continuación, aquellas que se han modificado más y en las que se encuentran los componentes más importantes de la app:

*   _**App\\Http**_: esta ruta puede considerarse el corazón de la aplicación. Dentro del directorio _Http_ encontramos los **controladores, las requests, servicios, middleware y el kernel,** que inicializa muchas utilidades necesarias para el correcto funcionamiento de la app. Dentro de esta localización también encontramos los modelos.
*   _**App\\Libraries:**_ aquí se encuentran los servicios creados para las API's.
*   _**Database**_: contiene el directorio _migrations_, utilizado en la construcción de la base de datos durante el inicio.
*   _**Public:**_ contiene todos los recursos que consume la aplicación. Esto incluye el javascript, css, imágenes o el archivo índice index.php, entre otros.
*   _**Resources/Views:**_ en este directorio se incluyen todas las vistas a las que recurre el front de la aplicación.
*   _**Routes/Web:**_ el archivo _web_ es el punto de entrada de la aplicación; el enrutamiento. Se encarga de asignar cada ruta entrante con su operación correspondiente.
*   _**Vendor:**_ contenedor de todas las librerías de Laravel. Cada vez que se necesita recurrir a la documentación, podemos explorar esta carpeta en búsqueda de información acerca de las clases.

### 2. Tecnologías

*   Laravel Framework 5.8
*   PHP 7.3.6
*   MySQL 5.7
*   HTML5
*   CSS4
*   Javascript / jQuery

### 3. Arquitectura en Laravel

Este framework de PHP se caracteriza por una estructura concreta que surge a la hora de lanzar la creación del proyecto. Se comenta a continuación cómo crear el proyecto a través de la consola Artisan incluida con Laravel y se realiza un breve acercamiento a la estructura para dar una visión general de sus elementos.

Para crear un proyecto en Laravel, se ha usado la consola **GitBash**. Laravel, asimismo, emplea **Composer** para la descarga de sus librerías. Composer es un gestor de paquetes muy conocido y ampliamente utilizado para este cometido.

El primer paso es la descarga del framework. Para su instalación se debe ejecutar el siguiente comando:

_composer global require laravel/installer_

Una vez instalado el framework, podemos proceder a la creación de un proyecto. El comando sería este:

_composer create-project –prefer-dist laravel/laravel projectname_

En este proyecto se ha utilizado durante la producción el programa XAMPP para el despliegue de servidor Apache y el empleo de la herramienta phpMyAdmin. No obstante, si quisiéramos lanzarlo de forma manual, podemos lanzar un servidor de desarrollo mediante el comando _php artisan serve_.

Más adelante se amplía la información acerca de las ventajas de esta consola de Laravel.

Una vez creado el proyecto, podemos acceder a él para ver su estructura y componentes. Según la documentación, esta estructuración de elementos está pensada para la creación de aplicaciones de larga y pequeña envergadura. Los subdirectorios del _root directory_ o directorio principal se explican a continuación.

#### 3\. 1. App

Contiene el núcleo de la aplicación. Las principales clases y todo el conjunto de la lógica se encuentran aquí. En la realización de este proyecto ha sido el más utilizado.

#### 3\. 2. Bootstrap

Contiene el archivo app.php que lanza la aplicación. Alberga otro subdirectorio, _cache_, que contiene archivos generados por el framework para la optimización del rendimiento.

#### 3\. 3. Config

Como su nombre indica, contiene los archivos de configuración de la aplicación. Merece la pena echar un vistazo antes de empezar con la construcción en sí del proyecto.

#### 3\. 4. Database

Contiene las migraciones (de crucial importancia para la creación de la base de datos en la ejecución del proyecto), la información base para la implementación de los modelos y los _seeds_ o generadores de datos. Aquí se perfilan los detalles de la construcción de la base de datos, ya que se definen las tablas con sus respectivos elementos y restricciones (DDL en lenguaje de bases de datos).

#### 3\. 5. Public

Es el directorio principal y contiene el _index.php_. Es el punto de entrada para todas las peticiones dirigidas a la aplicación. También se incluyen aquí otros recursos, como los archivos Javascript, el css o las imágenes.

#### 3\. 6. Resources

Principalmente usado porque contiene todas las vistas del proyecto. Estas se organizan en diferentes secciones. Aparte de ellas, encontramos archivos no compilados, como por ejemplo SASS o LESS, así como archivos de configuración de idiomas.

#### 3\. 7. Routes

Fundamental, ya que interviene mediante el archivo _web.php_ en el enrutamiento de las peticiones lanzadas contra la aplicación. Aparte de este archivo, encontramos otros tres: _api.php, console.php_ y _channels.php_. En este caso se ha usado principalmente el _web.php._

#### 3\. 8. Storage

Aquí podemos encontrar los archivos blade compilados, archivos de la caché y otros generados por el framework. Estos se encuentran repartidos por otros tres directorios: app, framework y logs.

#### 3\. 9. Tests

Contiene los tests automatizados. Toda esta parte de testing y automatización se conoce con el nombre de Laravel Dusk, y te permite realizar una serie de pruebas de funcionamiento contra tu aplicación.

#### 3\. 10. Vendor

De gran importancia por la información que contiene. En él se encuentran todas las clases y librerías del framework, por l o que es una excelente fuente de datos para resolver dudas, ver cómo funciona el framework, así como la herencia entre distintas clases, los distintos objetos que podemos encontrar y los métodos a los que tendremos acceso. La explicación de la estructura general la vamos a dejar hasta aquí. Para comprender a fondo cada uno de los directorios y sus respectivos cometidos, se puede consultar la documentación aquí: [https://laravel.com/docs/5.8](https://laravel.com/docs/5.8) . De cualquier manera, también se explicará más adelante la lógica seguida en los controladores de la aplicación, haciendo referencia a los detalles de la implementación.

### 4. Componentes principales

#### 4\. 1. Punto de entrada: el archivo web

            `'ShowController@display',
                        'as' => 'shows.display.root'
                    ]);

                    Route::group(['prefix' => 'shows'], function() {

                        Route::get('display', [
                            'uses' => 'ShowController@display',
                            'as' => 'shows.display'
                        ]);

                        Route::get('next', [
                            'uses' => 'ShowController@getNextSliderImage',
                            'as' => 'shows.next',
                            'middleware' => 'signed'
                        ]);

                        Route::get('previous', [
                            'uses' => 'ShowController@getPreviousSliderImage',
                            'as' => 'shows.previous',
                            'middleware' => 'signed'
                        ]);

                        Route::get('count', [
                            'uses' => 'ShowController@getNumberOfShows',
                            'as' => 'shows.count',
                            'middleware' => 'signed'
                        ]);
                        
                        Route::post('get_hash_url_token', [
                            'uses' => 'ShowController@getUrlHashToken'
                        ]);
                    });

                    Route::group(['prefix' => 'account'], function() {

                        Route::get('display', [
                            'uses' => 'AccountController@display',
                            'as' => 'account.display'
                        ]);

                        Route::post('validate', [
                            'uses' => 'AccountController@validateUpdate',
                            'as' => 'account.validate'
                        ]);

                        Route::post('delete', [
                            'uses' => 'AccountController@deleteAccount',
                            'as' => 'account.delete'
                        ]);
                        
                    });

                    Route::group(['prefix' => 'paintings'], function() {

                    Route::get('display', [
                            'uses' => 'PaintingsController@display',
                            'as' => 'paintings.display'
                        ]);

                        Route::get('load/{id}/{imagesLoaded}/{remainingImages}', [
                            'uses' => 'PaintingsController@loadMorePictures',
                            'as' => 'paintings.load',
                            'middleware' => 'signed'
                        ]);
                        
                    Route::post('upload', [
                        'uses' => 'PaintingsController@uploadPaint',
                        'as' => 'paintings.upload'
                        ]);

                    Route::post('get_image_preview', [
                            'uses' => 'PaintingsController@getImagePreview',
                            'as' => 'paintings.get_preview'
                        ]);

                        Route::post('delete_preview', [
                            'uses' => 'PaintingsController@deletePreviews',
                            'as' => 'paintings.delete_preview'
                        ]);

                        Route::post('get_hash_url_token', [
                            'uses' => 'PaintingsController@getUrlHashToken'
                        ]);

                        Route::post('update', [
                            'uses' => 'PaintingsController@updatePaint',
                            'as' => 'paintings.update'
                        ]);

                        Route::post('delete', [
                            'uses' => 'PaintingsController@deletePaint',
                            'as' => 'paintings.delete'
                        ]);

                    });

                    Route::group(['prefix' => 'galleries'], function() {

                        Route::get('display', [
                            'uses' => 'GalleriesController@display',
                            'as' => 'galleries.display'
                        ]);

                        Route::post('add/{galleryId}', [
                            'uses' => 'GalleriesController@addGallery',
                            'as' => 'galleries.add'
                        ]);

                        Route::get('details', [
                            'uses' => 'GalleriesController@getGalleryDetails',
                            'as' => 'galleries.details',
                            'middleware' => 'signed'
                        ]);

                        Route::post('delete/{galleryId}', [
                            'uses' => 'GalleriesController@deleteGallery',
                            'as' => 'galleries.delete'
                        ]);

                        Route::get('reload', [
                            'uses' => 'GalleriesController@reloadGalleries',
                            'as' => 'galleries.reload',
                            'middleware' => 'signed'
                        ]);

                        Route::post('get_hash_url_token', [
                            'uses' => 'GalleriesController@getUrlHashToken'
                        ]);

                    });

                    Route::group(['prefix' => 'paintings'], function() {

                        Route::get('display', [
                            'uses' => 'PaintingsController@display',
                            'as' => 'paintings.display'
                        ]);
                    
                        Route::get('load/{id}/{imagesLoaded}/{imagesToLoad}', [
                            'uses' => 'PaintingsController@loadMorePictures',
                            'as' => 'paintings.load'
                        ]);
                    
                        Route::post('upload', [
                            'uses' => 'PaintingsController@uploadPaint',
                            'as' => 'paintings.upload'
                        ]);
                    
                        Route::post('get_image_preview', [
                            'uses' => 'PaintingsController@getImagePreview',
                            'as' => 'paintings.get_preview'
                        ]);
                    
                        Route::post('delete_preview', [
                            'uses' => 'PaintingsController@deletePreviews',
                            'as' => 'paintings.delete_preview'
                        ]);
                    
                    });
                    
                    Route::group(['prefix' => 'messages'], function() {
                    
                        Route::get('display', [
                            'uses' => 'MessagesController@display',
                            'as' => 'messages.display'
                        ]);

                        Route::get('handle_request', [
                            'uses' => 'MessagesController@handleMessageRequest',
                            'as' => 'messages.request', 
                            'middleware' => 'signed'
                        ]);

                        Route::post('execute_request', [
                            'uses' => 'MessagesController@executeMessageRequest',
                            'as' => 'messages.execute'
                        ]);

                        Route::post('get_hash_url_token', [
                            'uses' => 'MessagesController@getUrlHashToken'
                        ]);
                    
                    
                    });

                    Route::group(['prefix' => 'sales'], function() {

                        Route::get('display', [
                            'uses' => 'SalesController@display',
                            'as' => 'sales.display'
                        ]);

                        Route::post('upload_on_ebay', [
                            'uses' => 'SalesController@uploadPaintOnEbay',
                            'as' => 'sales.upload'
                        ]);

                    });

                    Auth::routes(['verify' => true]);

                    Route::get('/home', 'HomeController@index')->name('home');` 
        

Lo primero que se ejecuta en la aplicación es el enrutamiento de la misma. Esta la lleva a cabo el archivo _web.php_ dentro de la carpeta _Routes_. Esta clase se caracteriza por ser muy versátil y por aceptar distintos tipos de formato. En el caso de Kontollarte, se ha optado por la organización en distintos grupos según el controlador. De este modo, empleando la _facade Route_ proporcionada por Laravel, se han construido diferentes grupos con el método _group_, mientras que las peticiones como tal se han hecho con _get_ y _post_. Las _facades_ son un tipo de clase en Laravel, cuyo funcionamiento es muy parecido sintácticamente al de una clase estática. De este modo, proporcionan métodos muy útiles en diversidad de ámbitos.

No vamos a extendernos más en la explicación de este archivo. Simplemente mencionaremos que, además de las utilidades que ofrece para el enrutamiento, proporciona además opciones para la asignación de middleware o para el retorno de vistas.

Para más información: [https://laravel.com/docs/5.8/routing.](https://laravel.com/docs/5.8/routing.)

#### 4\. 2. Middleware

Se puede entender el middleware como un entramado de contención que se ejecuta de forma previa a la gestión de una petición. Son muchos y eficientes los que Laravel propone. Entre ellos cabe destacar los referidos al control de sesiones, verificación de usuarios o autenticación, entre otros. No vamos a explicar todo su contenido. Para ello podemos consultar la documentación aquí:

[https://laravel.com/docs/5.8/middleware.](https://laravel.com/docs/5.8/middleware.)

Como es costumbre en Laravel, esta parte también responde ante comandos para su creación. Si queremos crear uno, haremos lo siguiente:

_php artisan make:middleware SessionManager_

En el caso de Kontollarte, se ha empleado la estructura y funcionalidad del middleware para crear una clase concreta de este tipo llamada _SessionManager_. Esta se aplicará a los controladores “internos”, es decir, aquellos que gestionan el funcionamiento de la aplicación una vez que el usuario se ha logueado. De este modo, el siguiente paso a la creación del middleware, es la inyección del mismo en los respectivos controladores. Esto se puede hacer de distintos nodos: a través del archivo web del directorio _Routes_ o directamente en el constructor del controlador. En este caso se ha optado por la inyección de la dependencia en el constructor, ya que facilita la segregación de los archivos y permite una mayor diferenciación entre los tipos de clase.

Clase _SessionManager:_

            `class SessionManager
                {
                    /**
                    * Handle an incoming request.
                    *
                    * @param  \Illuminate\Http\Request  $request
                    * @param  \Closure  $next
                    * @return mixed
                    */
                    public function handle($request, Closure $next)
                    {
                        return SessionController::getInstance($request)
                                        ->handleRequest() ? $next($request) : redirect()->route('login');
                    }
                }` 
        

Como se viene explicando, se ha implementado un middleware que controlará las sesiones: _Session Manager_, que implementa el método _handle_, a través del cual se gestiona el flujo de datos a través de la aplicación, así como la navegación por parte del usuario. Este método devolverá _true_ siempre que se pasen las validaciones correspondientes en la clase _SessionController_ .En caso contrario, devolverá false y, por tanto, una redirección al login.

¿Qué es lo que hace esta clase _SessionController_? Pues bien, este controlador es, por decirlo de algún modo, el base; y, a partir de él, se pasa a concretar a qué controlador se dirige la app. Se ha tratado de dotar a esta clase de una estructura sólida y robusta, fuertemente protegida mediante métodos privados internos que llevan a cabo una escrupulosa validación. Esto se ha podido realizar gracias a elementos como la modularización en distintas funciones, la comprobación de nulos y la inclusión de las propiedades necesarias.

El middleware, además, debe registrarse en una clase de Laravel llamada _kernel_, que digamos que funciona a modo de carga de todos los servicios de middleware. Existen distintos tipos y cada uno de ellos se aplica con una frecuencia distinta. En nuestro caso, lo hemos registrado en el array _routeMiddleware_, donde se introducen los middleware aplicados a grupos o de forma individual.

#### 4\. 3. Controladores

##### 4\. 3. 1. Controladores en la autenticación: _LoginController_ y _RegisterController_

Gracias al paquete _auth_ de Laravel, se generan una serie de clases relativas a la autenticación de los usuarios. Estas sirven de base para extender los métodos según las necesidades de la aplicación. El comando que hay que ejecutar es el siguiente:

_php artisan make:auth_

Más información sobre el paquete _auth_: [https://laravel.com/docs/5.8/authentication.](https://laravel.com/docs/5.8/authentication.)

Esto genera, como se indicaba, la creación de las clases necesarias para el login y registro. Lo siguiente es acomodarlo a las necesidades de la aplicación.

![login](https://github.com/ivanmirandastavenuiter/kontollarte-app-laravel-production/blob/master/KONTOLLARTE_DOCS/PICS/1.PNG)

¿Cómo se ha llevado a cabo este paso? Sobre todo, haciendo uso de la clase _Request_. Esta clase hereda de otra llamada _FormRequest_ y se utiliza para implementar validaciones, de modo que cada una se corresponde con un tipo de formulario completo. Gracias a ella, podemos hacer una para una función específica y asignarle la validación correspondiente. Esta clase se ha usado para todas las validaciones en el proyecto. Se caracteriza por tres métodos fundamentales:

*   _Rules_
*   _Messages_
*   _Authorize_

Mediante el primero se establecen los requisitos necesarios para pasar la validación. Los _messages_ devuelven los mensajes mostrados en caso de algún error. _Authorize_ es un boolean que permite la ejecución de la petición en caso de tener el valor _true_.

En la clase _LoginController_, así como también en la _RegisterController_, la implementación se organiza a través de la inclusión de _traits_. Estos son, de algún modo, parecidos a clases hijas que extienden la funcionalidad de las que heredan.

Los _traits_ usados en _LoginController_ son:

*   _AuthenticateUsers_
*   _RedirectUsers_
*   _ThrottlesLogin_

En el _RegisterController_:

*   _RegisterUsers_
*   _RedirectUsers_

¿Dónde encuentro estas clases? En el directorio _vendor_. Esta es una parte importantísima de Laravel: aquí encontramos todo el material relativo a la construcción del framework, de modo que siempre que usemos una clase nativa, recurriremos a este directorio a la hora de buscar información. En concreto, el paquete usado aquí es este:

_Illuminate/Foundation/Auth_

Así, navegando por los subdirectorios, podemos encontrar las distintas implementaciones del framework que nos interesen en cada momento del desarrollo.

¿Qué métodos se han modificado en _LoginController_ y _RegisterController_? Tanto en uno como en otro, los _traits_ se han tocado para aceptar _requests_ concretas y personalizadas para la ejecución del login y el registro. Por otro lado, en lo relativo al login, se han modificado métodos, como por ejemplo el _authenticate_. En el registro, se han introducido cambios en _register_. Todos ellos se han pensado de cara a iniciar el control de sesiones necesario tanto en el login como en el registro.

Para más información consultar sendos controladores en _App/Http/Controllers/Auth._

![register](https://github.com/ivanmirandastavenuiter/kontollarte-app-laravel-production/blob/master/KONTOLLARTE_DOCS/PICS/2.PNG)

Ejemplo de inserción de modificaciones en los traits de la clase _LoginController:_

   
            `/**
                * Handle a login request to the application.
                *
                * @param  App\Http\Requests\LoginRequest $request
                * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
                *
                * @throws \Illuminate\Validation\ValidationException
                */
               public function login(LoginRequest $request)
               {
                   $this->validateLogin($request);
           
                   // If the class is using the ThrottlesLogins trait, we can automatically throttle
                   // the login attempts for this application. We'll key this by the username and
                   // the IP address of the client making these requests into this application.
                   if ($this->hasTooManyLoginAttempts($request)) {
                       $this->fireLockoutEvent($request);
           
                       return $this->sendLockoutResponse($request);
                   }
           
                   if ($this->attemptLogin($request)) {
                       return $this->sendLoginResponse($request);
                   }
           
                   // If the login attempt was unsuccessful we will increment the number of attempts
                   // to login and redirect the user back to the login form. Of course, when this
                   // user surpasses their maximum number of attempts they will get locked out.
                   $this->incrementLoginAttempts($request);
           
                   return $this->sendFailedLoginResponse($request);
               }` 
        

##### 4\. 3. 2. _SessionController_: el gestor de entrada

Como ya se ha señalado previamente, este controlador es el que gestiona el método lanzado por _SessionManager_. Como cabe pensar, el control de sesiones se realiza solamente en los controladores indicados, que son los siguientes:

*   _ShowController_
*   _AccountController_
*   _PaintingsController_
*   _MessagesController_
*   _GalleriesController_
*   _SalesController_

Las clases excluidas son _LoginController_ y _RegisterController_. En el momento en el que el usuario se loguea, se lanza la instanciación de este controlador mediante _SessionManager_, que si recordamos, es el middleware aplicado para el control de sesiones.

Esto en un principio generó una problemática: los elementos _middleware_ se ejecutan en Laravel antes que los controladores. Esto hizo que la inyección de dependencias provista por el _ServiceContainer_ (algo así como un contenedor general de servicios para la aplicación) no se diese para cuando el controlador era instanciado. De este modo, no teníamos acceso a la petición mediante el objeto _Request_, también importantísimo.

Método principal de la clase _SessionController:_

            `/**
                * Provides session instance on middleware.
                *
                * @param  \Illuminate\Http\Request $request
                * @return \App\Http\Controllers\SessionController
                */
               public static function getInstance(Request $request) 
               {
                   if ($request->session()->has(self::CURRENT_USER_SESSION)) {
                       self::$instance = $request->session()->get(self::CURRENT_USER_SESSION);
                       self::$instance->setRequest($request); // Updates actual request
                       self::$instance->put(self::CURRENT_USER_SESSION, self::$instance); // Stores session controller
                   } else {
                       if (is_null(self::$instance)) {
                           self::$instance = (new SessionController());
                           self::$instance->setRequest($request); // Sets first request
                           self::$instance->put(self::CURRENT_USER_SESSION, self::$instance); // Stores session controller
                       }
                   }
                   return self::$instance;
               }` 
        

Más información sobre _Request_: [https://laravel.com/docs/5.8/requests.](https://laravel.com/docs/5.8/requests)

Lo que se hizo para solucionar este escollo fue pasarle de forma manual el objeto _Request_ al método estático _getInstance()_, lo que permitió desencadenar el resto de funciones. Este asigna el objeto _Request_ y evalúa mediante _handleRequest()_ si debe permitir el paso o no del usuario. Se recomienda ver la clase completa para su correcta comprensión.

##### 4\. 3. 3. Controladores internos

Una vez pasada la validación, existen unos controladores que gestionan el funcionamiento de la aplicación para cada una de sus funciones. Todos ellos tienen en común que aplican de forma recursiva el _SessionController_ mediante una propiedad privada: _session_. Por otro lado, también comparten la aplicación de la interfaz _IHasher_, que se encargará de asegurar las rutas _get_ para evitar su acceso a través del exterior de la aplicación. Se excluyen de este grupo las rutas relativas a la función _display_ de todos los controladores, ya que esta debe ser accesible para poder ver el contenido de cada una de las pestañas. Comentar que el método _getUrlHashToken_ se aplica de un modo concreto para cada una de las clases. En todos ellos se da, asimismo, la inyección de la dependencia _Request_.

##### 4\. 3. 3. 1. _ShowController_

Este controlador es el primero que se lanza tras el logueo y es a dónde se dirige al usuario cuando este se registra. Esta página muestra una serie de eventos, todos ellos seleccionados uno a uno mediante un slider, acompañado de la información relativa a ese evento en concreto. Más adelante se comentará la lógica aplicada con _jQuery_ para su funcionamiento.

Métodos aplicados:

*   _Display:_ el método común de entrada. Muestra el aspecto inicial de la sección. En este caso, se utiliza el _ArtsyAPIProvider_, clase elaborada para la interacción con la API de Artsy. Aplicación del método global _view()_ y _with()_, que permiten acciones muy interesantes de cara a la muestra de las vistas.
    
*   _FixHeightAndWidth:_ modifica altura y anchura de las imágenes para adaptarlas al contenedor existente en la vista.
    
*   _ParseDataToJSON:_ método que organiza en formato JSON y que será empleado por los métodos _GetNextSliderImage_ y _GetPreviousSliderImage_.
    
*   _GetNextSliderImage:_ extracción de la siguiente imagen. Uso del objeto _User_ para proveer de la información necesaria. Uso de sesiones para almacenamiento del usuario.
    
*   _GetPreviousSliderImage:_ extracción de la imagen anterior a la actual. Uso del objeto User para proveer de la información necesaria. Uso de sesiones para almacenamiento del usuario.
    
*   _GetNumberOfShows:_ devuelve un entero con el número total de eventos
    

![shows](https://github.com/ivanmirandastavenuiter/kontollarte-app-laravel-production/blob/master/KONTOLLARTE_DOCS/PICS/3.PNG)

##### 4\. 3. 3. 2. _AccountController_

El _AccounController_ se encarga de gestionar la cuenta del usuario, pudiendo hacer modificaciones en la cuenta y ofreciendo la posibilidad de borrarla.

Métodos aplicados:

*   _GetUserLogged:_ usa el controlador de sesiones para devolver el objeto _User_ almacenado.
    
*   _Display:_ método común de entrada. Muestra el aspecto inicial de la sección.
    
*   _ValidateUpdate:_ se encarga de asegurar que las propiedades introducidas no se están repitiendo en la base de datos. Empleo de la _facade Validator_ y su método _make_, que se encarga de validar las reglas correspondientes a una petición. Uso del _global helper redirect()_ y del método _route()_, que nos permite introducir el nombre de una ruta (asignado en el archivo web en _Routes_).
    
*   _DeleteAccount:_ realiza el borrado del usuario y devuelve la vista correspondiente.
    
*   _CheckNewInputsAgainstDatabase:_ método auxiliar en la validación que comprobará que los valores obligatorios no se den más de una vez. Resaltar la aplicación aquí de la clase _MessageBag_, la cual es la usada por Laravel para la construcción de errores. Tomamos como base la documentación y generamos nuestros propios objetos de este tipo para acoplarlo con la estructura de las vistas. La clase se encuentra en la ruta _Illuminate/Support/MessageBag_. En la API de Laravel se pueden consultar sus métodos y propiedades.
    

![account](https://github.com/ivanmirandastavenuiter/kontollarte-app-laravel-production/blob/master/KONTOLLARTE_DOCS/PICS/4.PNG)

##### 4\. 3. 3. 3. _PaintingsController_

Gestiona todo lo relativo a las obras del autor. Se comienza el proyecto con la perspectiva de que fuesen cuadros únicamente, pero se piensa en la posibilidad de cambiar esto para introducir todo tipo de géneros de arte.

¿De qué se encarga principalmente esta clase? Pues permite las funcionalidades de subir una obra al servidor, modificarla y borrarla.

Métodos aplicados:

*   _GetUserLogged:_ usa el controlador de sesiones para devolver el objeto _User_ almacenado.
    
*   _Display:_ método común de entrada. Muestra el aspecto inicial de la sección. Aquí nos vamos a parar en un par de detalles que merece la pena comentar.
    
    La lógica está pensada para cargar las obras de 2 en 2. Investigando sobre cómo hacer esto con Laravel y se descubren dos cosas:
    
    *   _Eloquent Model:_ [https://laravel.com/docs/5.8/eloquent](https://laravel.com/docs/5.8/eloquent)
    *   _Query Builder:_ [https://laravel.com/docs/5.8/eloquent](https://laravel.com/docs/5.8/queries)
    
    _Eloquent_ es la sección de Laravel que se refiere a la interacción con base de datos, así como su estructura. _Query Builder_ es, como su propio nombre indica, un objeto que permite realizar consultas similares sintácticamente hablando al lenguaje SQL.
    
    Siguiendo estas directrices, y usando los modelos propios de la clase, se recurre a métodos como _where(), count(), limit() y get(),_ entre otros. Los primeros se parecen, como podemos apreciar, al nombre que tienen algunas funciones en SQL. El último de ellos, el get es necesario para extraer el objeto y almacenarlo. Se recurre a _view()_ y _with()_ para el retorno de vistas. Estos permiten el paso de variables a través de arrays asociativos.
    
*   _LoadMorePictures:_ este método se encarga de actualizar las obras del usuario en la vista, cargándolas de dos en dos. Se llama desde AJAX y emplea los métodos de _QueryBuilder skip()_ y _take()_, que indican, respectivamente, un salto entre consultas y el número de ítems a devolver.
    
*   _UploadPaint:_ valida la subida de la obra. Obligará al usuario a introducir todos los campos requeridos, mostrando los errores en caso contrario. Uso del método _input_ en _Request_ para extraer la información pasada desde el formulario. Uso del método _file_ para devolver el archivo con formato de imagen. Introducción de expresiones regulares para la eliminación de caracteres indeseados en el nombre de la imagen, los cuales daban lugar a problemas en su uso posterior. Método _preg\_replace_ para su aplicación. Introducción en base de datos con el método _create_. Envío de booleanos como anteriormente a través de las vistas.
    
*   _UpdatePaint:_ estructura similar al anterior, puesto que el proceso es el mismo salvo por la consulta de base de datos, que en este caso actualiza en lugar de crear una nueva instancia. Mencionar aquí que surgió un problema al introducir la posibilidad de las actualizaciones: debido a que los dos formularios comparten los mismos campos, aparecieron dificultades en la separación de ambos a la hora de devolver los errores. En Laravel, estos se solapan de forma automática a la sesión actual del usuario, pero no se estaba identificando qué tipo de error se estaba mostrando. O mejor dicho, qué tipo de formulario era el que estaba enviando los errores. Investigando, encontramos el objeto _MessageBag_ y vemos que una de sus propiedades (el nombre) permite una identificación de la estructura de errores. Para llevar a cabo el paso de información se modifican los métodos _failedValidation_ y _getRequestUrl_, sobrescribiendo así los de la clase padre.
    
*   _DeletePaint:_ borrado del elemento. Se usa el objeto _QueryBuilder_ para su búsqueda con _where_ y posterior borrado con _delete()_.
    
*   _DeletePreviews:_ en el formulario de subida, se dota a este de una función que ofrece al usuario la posibilidad de subir una imagen. Surgía aquí el problema de dónde tomar la fuente de esa imagen, ya que esta en un principio se encontraba en local en el pc del usuario. Por tanto, lo que se hace es cargar esa imagen, almacenarla para mostrar la vista previa y, en el momento de ejecutar la validación, proceder a su borrado. De este modo, lo que asegura este método es que, después de cada operación, se borren todas las vistas previas.
    
*   _GetImagePreview:_ es el método que realiza el guardado de la imagen para su posterior introducción en el formulario.
    
*   _GetUrlHashToken:_ uso de la _facade URL_ y su método _signedRoute_ para devolver el token necesario que ejecute la operación deseada. Se prevee el uso o no de parámetros según el contexto.
    

##### 4\. 3. 3. 4. _GalleriesController_

Se encarga de extraer la información relativa a las galerías. Lo que pretende es facilitar al usuario el descubrimiento de galerías para su posterior contacto y posible venta de trabajos.

Métodos aplicados:

*   _Display:_ método común de entrada. Muestra el aspecto inicial de la sección. Aquí este método está bastante desarrollado. Hay varios detalles a comentar.
    
    Como ya ocurre en otros controladores, se hace uso de la propiedad _session_ para el manejo del objeto _User_.
    
    Por otro lado, cabe destacar algunas utilidades de los modelos de _Eloquent_, como por ejemplo el método _refresh()_. Este trae de nuevo la información de la base de datos. Se introdujo debido a que precisamente la información no se actualizaba correctamente.
    
    Otra utilidad es _old_, que trae los valores de la validación previa. En este caso se aplica para dirigir la lógica por un camino u otro.
    
    Muy usada ha sido también la clase _Collection_ de Laravel. Este ha sido uno de los mejores puntos del proyecto, puesto que este tipo de objetos es fácilmente manipulable y altamente útiles. Podemos encontrar más información aquí:
    
    [https://laravel.com/docs/5.8/collections](https://laravel.com/docs/5.8/collections)
    
    Aplicando todas estas utilidades, el código discierne entre cargar nuevas galerías o traer las que ya se habían cargado previamente.
    
*   _AddGallery:_ añade una nueva galería a la lista personal del usuario. ¿Qué aspectos controla este método? La lógica está estructurada de la siguiente manera: se guardarán en base de datos aquellas galerías que no aparezcan en la misma. De este modo, la primera vez se guardaría y de ahí en adelante podrá ser usada por otros usuarios sin ejecutar nuevas consultas innecesarias. Así, si el usuario elige una galería ya almacenada en base de datos, simplemente se asignan las correspondientes ids en la tabla intermedia. Recapitulando, comprueba primero si el usuario la tiene, y luego, si la base de datos la tiene. Si la base de datos no la tiene, se inserta. Si el usuario ya la tiene, se devuelve un mensaje indicando el error. Destacar el uso de métodos interesantes como _replicate()_ o _merge()._
    
*   _GetGalleryDetails:_ petición AJAX lanzada en el click de ver detalles.
    
*   _DeleteGallery:_ borra la galería de la lista del usuario.
    
*   _ReloadGalleries:_ toma nuevas galerías mediante el proveedor de la API. Uso de métodos _merge()_ en _Request_ y almacenamiento de objetos en sesión.
    
*   _GetUrlHashToken:_ uso de la _facade URL_ y su método _signedRoute_ para devolver el token necesario que ejecute la operación deseada. Se prevee el uso o no de parámetros según el contexto.

##### 4\. 3. 3. 5. _MessagesController_

Esta parte de la aplicación se encarga de la comunicación entre usuarios y galerías, haciendo uso de la librería PHPMailer para el envío de correo electrónico.

Métodos aplicados:

*   _Display:_ sigue aplicando una estructura parecida a los que venimos describiendo. Primero toma la información almacenada en sesión o base de datos, la manipula según el contexto y la muestra retornando la vista.
    
*   _HandleMessageRequest:_ gestiona en un primer momento el envío del mensaje, pero no lo ejecuta. Se produce al hacer click en el botón de enviar, abriendo un modal en el que se pueden consultar los detalles del correo. Esta parte está muy elaborada, ofreciendo los detalles tanto del mensaje, como los trabajos del usuario para que este pueda adjuntarlos al correo. Esta función se implementa mediante checkboxes que contienen la id de los trabajos.
    
    En este método simplemente se recibe la información y se asigna al modal.
    
*   _ExecuteMessageRequest:_ ejecuta el envío del correo elaborado mediante el método anterior. Mediante jQuery se capturan los datos y se trasladan al controlador.
    
    La lógica a la hora de insertar mensajes y destinatarios funciona de la siguiente manera:
    
    *   Se inserta un mensaje por correo.
        
    *   Se insertan los destinatarios que no estén ya en la tabla. Si estos, a la hora de insertar el mensaje, se encontrasen ya almacenados, simplemente se modifica la tabla intermedia. Esto pretende conseguir una mayor eficiencia en el rendimiento, evitando la repetición de registros. ¿Qué cabe destacar de este método? Pues el empleo de la _facade DB_ para el acceso a datos o, por ejemplo, el método _pluck_, que te permite extraer una sola columna de la fila devuelta.
        
*   _SendMailThroughSMTP:_ es la aplicación de la librería PHPMailer. Por defecto, se encuentra deshabilitada para no mandar correos indeseados por accidente. Los campos que habría que cambiar son _email (destinatario), username, password, setFrom_ y _addReplyTo_.
    
*   _WriteHTMLMessage:_ almacena el mensaje en formato HTML para adecuarlo al correo electrónico.
    
*   _GetUrlHashToken:_ uso de la _facade URL_ y su método _signedRoute_ para devolver el token necesario que ejecute la operación deseada. Se prevee el uso o no de parámetros según el contexto.
    

##### 4\. 3. 3. 6. _SalesController_

Es el último de los controladores. Se encarga de gestionar la subida de los trabajos a la plataforma de Ebay. Su aplicación fue de las más complicadas, puesto que la estructura de las peticiones así como el funcionamiento de la API son bastante tediosas y complejas de entender.

Métodos aplicados:

*   _Display:_ aplica la misma estructura que en los casos anteriores. Se obtiene la información, se procesa y se muestra la respectiva vista con los parámetros que fuesen necesarios. Se sobrescribe de nuevo el método _failedValidation_ de la clase _SellPaintRequest_, modificando la url de redirección para que contenga un _flag_ en caso de error. De este modo, el controlador sabe si la redirección procede o no de un error y actúa en consecuencia.
    
*   _GetTokenForRequest:_ token de 32 caracteres necesarios para el funcionamiento de las peticiones.
    
*   _UploadPaintOnEbay:_ validación mediante _Validator_ y asignación de variables procedentes del formulario. Establecimiento de las dos peticiones necesarias, una para la subida y otra para la obtención del ítem. Utilización del _EbayAPIProvider_. Devolución de las vistas.
    

![sales](https://github.com/ivanmirandastavenuiter/kontollarte-app-laravel-production/blob/master/KONTOLLARTE_DOCS/PICS/11.PNG)

### _5. Eloquent_ y modelos

Eloquent es el ORM _(Object Relational Mapping)_ que Laravel emplea. Provee una sencilla implementación de la base de datos mediante el objeto _Model_. Las instancias de estos últimos se corresponden con las tablas y están fuertemente ligados a las migraciones, otro factor de gran importancia.

En primer lugar, vamos a explicar los modelos. En Laravel, para crear un modelo, se usa el siguiente comando:

_php artisan make:model Show_

En realidad es preferible aplicarlo para que cree de manera automática la migración correspondiente:

_php artisan make:model Show -m_

Esto genera una clase con una idiosincrasia concreta. Toda la información relativa a este tipo de clase la encontraremos en la API. El tipo concreto es:

_Illuminate/Database/Eloquent/Model_

Si la consultamos veremos que se caracteriza por implementar propiedades y métodos que definirán su comportamiento en base de datos. Pongamos un ejemplo: la siguiente imagen muestra la implementación del modelo _Show:_

Los métodos son muy importantes, ya que definen la relación y el posterior comportamiento de los modelos a la hora de interactuar con ellos. Los tipos de relaciones que podemos encontrar son las referentes a base de datos:

*   Uno a uno: se aplican en las dos clases los métodos _hasOne_.
    
*   Uno a muchos: se aplica en una clase _hasOne_ y en la que recibe _belongsTo_.
    
*   Muchos a muchos: se aplica _belongsTo_ en ambas clases.
    

La funcionalidad de los modelos es amplísima. Se recomienda su consulta en la documentación: [https://laravel.com/docs/5.8/eloquent-relationships](https://laravel.com/docs/5.8/eloquent-relationships)

En el caso de Kontollarte, estos son los modelos aplicados:

*   _User_
*   _Paint_
*   _Show_
*   _Gallery_
*   _Message_
*   _Image_
*   _Sale_
*   _Receiver_

Ahora tiene sentido comentar cómo funcionan las migraciones. Para crearlas, se debe usar:

_php artisan make:migration migrationName_

Las migraciones definen la estructura de base de datos a través de la implementación de dos métodos: _up_ y _down_. La definición de las tablas se realiza con la _facade Schema_, que aplicando el método _create()_, pasa la información de las tablas y los tipos de datos que esta contendrá.

Aquí se recurrió mucho a la documentación para la definición de tipos:

[https://laravel.com/docs/5.8/migrations](https://laravel.com/docs/5.8/migrations)

Se recomienda visitar la documentación para entender las migraciones en su sentido más amplio.

Ejemplo de migración en Laravel:

            `use Illuminate\Support\Facades\Schema;
                use Illuminate\Database\Schema\Blueprint;
                use Illuminate\Database\Migrations\Migration;

                class CreateGalleriesTable extends Migration
                {
                    /**
                    * Run the migrations.
                    *
                    * @return void
                    */
                    public function up()
                    {
                        Schema::create('galleries', function (Blueprint $table) {
                            $table->string('galleryId')->primary();
                            $table->string('galleryName');
                            $table->string('galleryAddress');
                            $table->string('galleryEmail')->unique();
                            $table->string('galleryWeb');
                            $table->timestamps();
                        });
                    }

                    /**
                    * Reverse the migrations.
                    *
                    * @return void
                    */
                    public function down()
                    {
                        Schema::dropIfExists('galleries');
                    }
                }` 
        

### 6. Scripts del lado cliente. _Javascript / jQuery_

La aplicación de script de lado cliente, tanto Javascript como jQuery, ha sido frecuente a lo largo de todo el proyecto. Para su explicación, la dividiremos según las secciones, explicando brevemente cada una de sus funciones y su comportamiento.

#### 6\. 1. Shows

Archivo: _shows-script.js_.

En primer lugar, se encuentra la función _loadNextShowImage_ y _loadPrevShowImage_. Para entender cómo funcionan, vamos a explicar primero el comportamiento de los clicks en los controles de la sección. La página controla mediante jQuery los clicks que se realizan en los botones siguiente y anterior mostrados bajo el slider. Al pulsarse, estos eliminan de forma dinámica la imagen que esté presente y pasan a cargar un gif que indicará que la página está buscando la siguiente. Para evitar que el usuario pulse de forma seguida el click, se añaden booleans para agregar o eliminar clases al div correspondiente y así evitar que se ejecute de forma repetida. El timeout que se establece es de 3 segundos. Los métodos usados aquí son:

*   _css()_
    
*   _setTimeout()_
    
*   _addClass() / removeClass()_
    
*   _hasClass()_
    
*   _click()_
    

En el momento que se detecta que el _flag_ se encuentra a _true_, se pedirá la siguiente imagen o la anterior dependiendo del elemento pulsado. Tanto una función como la otra funcionan de modo similar. El proceso empieza comprobando la ruta. ¿Por qué? Porque la página de shows se sirve tanto en la ruta / como en la ruta /shows/display, de modo que tenemos que vigilar este aspecto para acoplar la petición en la url correcta. Esta conclusión se extrajo del fallo que se produjo cuando esta opción no se contempló. Empleo aquí de _window.location.href_. A continuación, se ejecuta el método _getUrlHashToken_ (necesario para obtener el token para las rutas de tipo _get_). Se procede a realizar una petición AJAX que devolverá la información que nos interesa. Esta se acopla mediante selectores de jQuery. Se usan los métodos _children()_ y _remove()_ para limpiar el contenido previo. Se contemplan los errores de AJAX pasando los tres argumentos devueltos por la función de jQuery. El controlador de las imágenes se almacena en la variable _position._

La lógica que se sigue en esta página es la siguiente: esta sección pretende informar al usuario de eventos que puedan interesarle. El código de Javascript está pensado para almacenar hasta un máximo de 25 imágenes por sesión de forma dinámica. Cuando el usuario cierra sesión, los shows se eliminan automáticamente. Además, el código está preparado para servir imágenes si estas ya existen en base de datos. De lo contrario, se solicita una nueva de la API.

Los métodos comentados son los más relevantes de esta sección. No obstante, hay más aparte de estos:

*   _checkShowsOnDatabase():_ crea un simple formato para las fechas que se inyecta por html en el documento.
    
*   _getUrlHashToken():_ sirve para hacer una petición al servidor y que este devuelva el token para la url.
    

#### 6\. 2. Galleries

Archivo: _galleries-script.js_.

El código de cliente se inserta aquí para varias acciones. En primer lugar, para la muestra de los detalles de la galería. En principio, el usuario tiene un símbolo de + en el que, al clickar, mostrará el contenido de la galería seleccionada. Esto se controla mediante las funciones _.click()_ de los elementos _minusNodes_ y _plusNodes_. Se agrega a cada uno de ellos la id de la galería cuando estas son impresas por la vista. Tomando esta id como referencia, es posible luego modificarles el css, lo cual se lleva a cabo con el método _.css()_.

Otro método a mencionar es el que se dispara cuando se muestra el formulario de confirmación de borrado de la galería. Al abrirse este, se traen los detalles de dicha galería mediante una función de AJAX, que recupera los datos del servidor y los agrega dinámicamente. Una vez realizado el proceso, se llama al modal.

También cuenta con una última función de AJAX, que traerá más galerías en caso de querer recargar la página con más contenido.

#### 6\. 3. Paintings

Archivo: _paintings-script.js_.

Uso de nuevos métodos:

*   _change()_
    
*   _attr()_
    
*   _toggleClass()_
    
*   _fadeIn() / fadeOut()_
    

La primera función que observamos es la referida a la ejecución de la vista previa en el formulario de subida de imagen al servidor. Esta función pretende mostrar el aspecto que tendrá la imagen una vez insertada. Para ello, comienza detectando el click y el cambio en la barra de carga para que el botón de la vista previa responda ante ello. El código comprueba qué clase tiene el botón y agrega el texto correspondiente según tenga una u otra. De la misma manera, mostrará o cerrará la imagen dependiendo de la petición. Cabe destacar el uso de _FormData_, un objeto que alberga todos los elementos de un formulario y los agrupa en uno solo.

Se usan métodos para el parseo a JSON, así como manipulación de strings con _split_.

_LoadImage()_ se encarga de traer nuevas imágenes de 2 en 2. Controla la cantidad mediante las variables correspondientes. _ControlLoadButtonFlow()_ se encarga de mostrar o no el botón de cargar nuevas unidades siempre que se detecten en la base de datos. De lo contrario, este desaparece. _CatchDataOnUpdateClick_ y _CatchDataOnDeleteClick_ sirven para trasladar los detalles del trabajo seleccionado a los respectivos modales. Por último, _relocateLastChild_ recoloca el elemento en el centro si este no está agrupado con otro.

#### 6\. 4. Messages

Archivo: _messages-script.js_.

El primer método que encontramos es el click en el menú que despliega los mensajes, siempre y cuando estos existan. Al pulsar, se abre un cuadro que contiene la información de los mensajes enviados. Uso frecuente del método _css_.

Sin embargo, este método no es el más importante. El principal es el desencadenado al pulsar en enviar el formulario. Cuando esto sucede, la acción se previene con _e.preventDefault()_. Acto seguido, se capturan los elementos y se comprueban las galerías seleccionadas seleccionando todos los checkbox y pasándoles la función _each()_. Se obtiene el token de seguridad y se lanza la petición de AJAX para proceder a la muestra del modal en el que se señalarán los detalles del envío. En dicho modal veremos qué destinatarios hemos seleccionado, qué trabajos queremos añadir y el contenido del mensaje.

A continuación, si el usuario acepta, se recogen todos los checkboxes marcados relativos a los trabajos y se pasan las galerías, los trabajos y el mensaje al controlador, que se encargará de la ejecución del envío.

Como antes, vemos aquí también el uso de _relocateLastChild()_. _changeOnCheckboxClick()_ y _enableDisableSubmitButton()_ van a controlar que el botón de enviar solo esté disponible cuando tanto mensaje como galerías estén seleccionados.

#### 6\. 5. Navbar

Archivo: _navbar-script.js_.

La barra de navegación contiene bastante código para asegurar un buen funcionamiento _responsive_. Las funciones _resize_ y _scroll_ se usan para definir comportamientos según el tamaño y la altura a la que se encuentre la página. Se introducen factores de carácter condicional para que solo se ejecuten en caso de cumplir ciertas características, como por ejemplo en el _scroll_, que controla la altura y la anchura al mismo tiempo incluyendo o quitando clases. Se coloca también un boolean para permitir que el menú se abra o no según la disposición de la página en cada momento.

Las dos funciones principales son la de aumento de la altura en el scroll ascendente y la reestructuración vertical del menú en el punto de ruptura seleccionado. La primera de ellas se consigue añadiendo y colocando la clase _scrolled-bar_. La segunda se hace mediante comprobaciones de anchuras, siendo muy usado de nuevo el método _css()_.

#### 6\. 6. Sales

Archivo: _sales-script.js_.

Contiene la aplicación más elaborada de jQuery. Esta se aplica en el formulario enviado a la Ebay.

Lo primero que destacaría sería la función que se desencadena al pinchar en el botón de _submit_. Justo después, se captura el elemento clickado (el botón) y partir de él, se navega por los nodos cercanos para conseguir los elementos que se encuentran alrededor. Esto permite localizar elementos convenientes para el funcionamiento de la página. Así es, por ejemplo, como se selecciona el formulario apropiado según en qué botón se esté ejecutando el click. Una vez recuperados los elementos, se desencadena una animación y, a los tres segundos, se envía el formulario.

Lo más interesante es lo siguiente: en el formulario, al enviarse, este lleva una variable de tipo _hidden_ que almacenará la altura de la pantalla en el momento del envío, pasando esta información al servidor. En el método _failedValidation_ de la petición correspondiente, este elemento se recupera y se devuelve a la vista. Una vez recuperado, se toma de nuevo por jQuery y se hace una bajada animada hasta el punto en el que se encontraba el usuario. Destacar, aparte de los métodos, la captura de elementos con jQuery, que lo hace todo más sencillo.

Un ejemplo de código Javascript muy bueno es el de la sección de sales, que usa mucho la captura de elementos cercanos:

            `// Executed on submit click
                $('.submit-btn').click(function(e) {
            
                    e.preventDefault();
            
                    // All needed relatives are caught
                    formContainer = $(this).parentsUntil('.paint-row').last()
                    formContentContainer = formContainer.find('.form-content-container')
                    sellingForm = formContainer.find('form')
                    loadingContainer = formContainer.parent().find('.loading-container')
                    loadingParagraph = loadingContainer.children()
                    scrollReference = formContainer.parent().find('.paint-name');
                    
                    $('.current-path').val(window.location.href);
            
                    $(formContentContainer).css({
                        'height' : '0'
                    })
            
                    $('html, body').animate({scrollTop: scrollReference.offset().top - 100}, {duration: 500, easing: 'linear'});
            
                    $(loadingContainer).css({
                        'left' : '-30%'
                    })
            
                    // Loading bar beginning
                    setTimeout(function() {
            
                        $(loadingParagraph).css({
                            'opacity' : '0'
                        })
            
                    }, 1000)
            
                    // Loading bar growing
                    setTimeout(function() {
            
                        $(loadingContainer).css({
                            'left' : '0%'
                        })
            
                        $(loadingParagraph).text('Executing...');
            
                        $(loadingParagraph).css({
                            'opacity' : '1'
                        })
            
                    }, 2000)
            
                    // Finally, form is submitted
                    setTimeout(function() {
                        sellingForm.submit();
                    }, 3000)
            
                })` 
        

### 7. Estilo. CSS3, HTML5.

Los siguientes elementos propios de CSS han sido introducidos en la página:

*   Bootstrap grid layout: se usa bootstrap como base para el empleo del grid y flexbox, usándolos para la mayoría de las estructuras en la aplicación. Se recurre sobre todo a puntos de ruptura intermedios _(col-md-x)_, aunque en algunas ocasiones se emplea el _lg_ por falta de anchura en el redimensionamiento de la página. Otras clases son, por ejemplo, _container-fluid y container, row,_ o clases relacionadas con la disposición de los elementos flex: _justify-content-center, align-items-start, flex-column,_ etc.
    
*   Bootstrap margins & padings: Bootstrap es muy versátil y ofrece muchísimas utilidades. Una de ellas es la relativa a márgenes y paddings mediante clases _m-x y p-x_, que contienen niveles del 1 al 5 para indicar su intensidad.
    
*   Adaptación a navegadores: uso de las directivas _moz, webkit, ms_ y _o_ para la adaptación a todos los navegadores posibles. Esta se aplica a las propiedades más relevantes: _background, animation y transition_.
    
*   Aplicación de pseudoelementos _::after_ y _::before_: en muchas partes se incluyen estos pseudoelementos para agregar una mayor funcionalidad a las posibilidades del css.
    
*   Amplia variedad de selectores: se recurre a distintos tipos, como por ejemplo _last-child, nth-last-child, div\[class=’’\], div\[class^=’’\]_ o selectores anidados.
    
*   Uso de SASS: se emplea SASS para crear clases generales a partir de importación de parciales. Estas se engloban dentro de un documento .scss que mediante el comando sass en consola genera el css correspondiente.
    
*   Animaciones: la página contiene animaciones en casi todas las páginas, la mayoría de ellas implementando movimientos sencillos. Se usa frecuentemente la aplicación de la propiedad _position_, sobre todo a la hora de colocarlas como _absolute_ con los padres a _relative_ para un correcto redimensionamiento de la página.
    
*   Transiciones: también muy frecuentes en la app. Se usan, sobre todo, las propiedades de _transition, display, background y position._
    
*   Media query: uso de la etiqueta media query para la disposición correcta de los elementos al cambiar el tamaño de la pantalla. En la mayoría de las secciones se ha optado por centrar los elementos en la reducción de los tamaños.
    

### 8. Despliegue de la app

### 8\. 1. Despliegue en hosting privado

Dominio elegido: [www.kontollarte.com](http://www.kontollarte.com)

El hosting elegido ha sido **Fast Comet**. Se trata de un hosting privado. ¿Por qué se ha elegido finalmente un hosting de pago?

Por dos razones:

*   Por las limitaciones en la customización del sitio que tienen los hostings gratuitos
*   Por las críticas en foros hablando acerca de los despliegues con Laravel. En muchos de ellos se recomendaba la utilización de Fast Comet para lanzar la app.

El proceso ha sido el siguiente:

Empiezas logueándote con las credenciales. Accedes a esta pantalla:

![credentials](https://github.com/ivanmirandastavenuiter/kontollarte-app-laravel-production/blob/master/KONTOLLARTE_DOCS/PICS/12.PNG)

Nos vamos al cPanel tal y como se ve en esta imagen:

![cpanel](https://github.com/ivanmirandastavenuiter/kontollarte-app-laravel-production/blob/master/KONTOLLARTE_DOCS/PICS/13.PNG)

![cpanel](https://github.com/ivanmirandastavenuiter/kontollarte-app-laravel-production/blob/master/KONTOLLARTE_DOCS/PICS/14.PNG)

Vas a file manager y partir de aquí es todo muy intuitivo, por lo que no se incluirán capturas reflejando exactamente cada paso. De ahí en adelante, puedes crear archivos, directorios, mover, copiar, etc.

Lo fundamental es que el contenido tiene que residir en **public\_html**. De ahí en adelante, la personalización va en función de cada usuario.

Aquí es donde empezó la problemática: **el .htaccess para generar los redireccionamientos apropiados**. Lo que ocurrió en un principio, o más bien lo que se usó en un principo fue este .htaccess para el root del servidor web:

            `#Pruebas
    
                #RewriteRule ^/?documentacion/?$ /documentacion/ [L]
                #RewriteRule ^documentacion$ /aplicacion/public/documentacion [L,END]
                #RewriteRule ^(.*)$ /aplicacion/public/$1 [L]
                
                #RewriteCond %{REQUEST_URI} ^/documentacion/
                #RewriteRule (.*) /aplicacion/public/$1 [L]
                
                #RewriteRule ^/?documentacion/?$ /documentacion [L]
                
                #RewriteCond %{REQUEST_FILENAME} !-f
                #RewriteCond %{REQUEST_FILENAME} !-d
                #RewriteRule . /?aplicacion/public/?$ [L,R=301]` 
        

Sin embargo, la línea verdaderamente conflictiva era esta:

            `#RewriteRule ^(.*)$ /aplicacion/public/$1 [L]` 
        

¿Por qué? Pues porque, al contemplar todo tipo de caracteres, incluso la ausencia de los mismos, estaba "tragándose" todas las peticiones. De este modo, cualquier RewriteCond que se pusiera acababa fallando. Finalmente la solución la di con el siguiente código:

            `RewriteEngine On
                        Options FollowSymLinks
                        Options +Indexes
                        RewriteBase /
                        IndexOptions ShowForbidden
                        
                        RewriteCond %{REQUEST_URI} !^/documentacion/
                        RewriteRule ^ /aplicacion/public/%{REQUEST_URI} [L]` 
        

La opción _FollowSymLinks_ sirve para contemplar los enlaces simbólicos. _+Indexes permite indexar el contenido_ _RewriteBase establece el directorio sobre el que se actúa_. Y, por último, _IndexOptions ShowForbidden_ muestra los elementos ocultos.

Siguiente problemática: **el .htaccess y el .htpasswd**. Esto fue complicado porque generaba un problema concreto: arrojaba, tras la autenticación, un error 403 Forbidden. Buscando y buscando, parece ser que hay que añadir la siguiente línea al .htaccess de /documentacion:

            `ErrorDocument 401 "Authorisation Required"` 
        

No tiene mucho sentido, porque debería funcionar como tal mediante los dos archivos arriba mencionados. Sin embargo, fue el ajuste que permitió que finalmente funcionara.

Luego la configuración de la base de datos es muy sencilla. Te vas al cPanel, aquí:

![database](https://github.com/ivanmirandastavenuiter/kontollarte-app-laravel-production/blob/master/KONTOLLARTE_DOCS/PICS/15.PNG)

Asegúrate de que haces los siguientes pasos:

*   Crea la base de datos
*   Crea un usuario para la base de datos
*   Asocia la base de datos con el usuario

![ddb-credentials](https://github.com/ivanmirandastavenuiter/kontollarte-app-laravel-production/blob/master/KONTOLLARTE_DOCS/PICS/16.PNG)

![db-credentials](https://github.com/ivanmirandastavenuiter/kontollarte-app-laravel-production/blob/master/KONTOLLARTE_DOCS/PICS/17.PNG)

Realizados estos puntos, vas al phpMyAdmin del host y únicamente importas la base de datos con el archivo .sql

![phpmyadmin](https://github.com/ivanmirandastavenuiter/kontollarte-app-laravel-production/blob/master/KONTOLLARTE_DOCS/PICS/18.PNG)

### 8\. 2. Despliegue en máquina virtual

**Máquina servidora:** Debian9

**Máquina cliente:** Windows XP

Se intenta el despliegue de la aplicación con una máquina Debian8 en un principio. Finalmente, arrojaba un error a la hora de mostrar la página de inicio: no mostraba absolutamente nada; aparecía una pantalla en blanco. Todo esto, lógicamente, habiendo hecho ya los direccionamientos dns correspondientes, así como la creación del servidor virtual.

Lo que estaba ocurriendo era que php **no estaba desplegando/mostrando los errores**. Para ello, se incluyó en el archivo index.php del directorio /public las siguientes directivas:

            `ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);` 
        

Tras ello, al actualizar, se mostraba el error: un problema de caracteres en el archivo _**Illuminate\\Support\\Arr.php on line 384**_. Tirando de google, descubro qué es lo que ocurre en realidad: que la versión de php que maneja apache es obsoleta para Laravel, que requiere versiones superiores a 7.1.

Tras este fallo, se suceden una gran cantidad de intentos, todos ellos sin resultado. En un primer momento, el más lógico parecía ser limpiar php y reinstalar en la versión más reciente, configurando claro está la presencia de los módulos adecuados en el servidor apache. ¿Qué es lo que pasó? Pues que muchos comandos no funcionaba por falta de paquetes o de repositorios en /etc/apt/sources.list. Precisamente por esto, por manipular aquí y allí, se generaron otro tipo de errores, como por ejemplo fallos en el archivo **sources.list**. En resumen, tuve que tirar la máquina en repetidas ocasiones.

Uno de los fallos más recurrentes fue la caída de apache. Esto ocurrió muy a menudo, por lo que solía comprobar el estado del servidor con _systemctl status apache2_. No llegué a averigüar cuál era la razón por la cual el servidor se estaba cayendo, ya que el motivo que pensé que lo estaba provocando no resultó ser el único.

Resumiendo de nuevo, tiré la máquina y reinstalé con Debian9. Los pasos para, finalmente, lograr que funcionara fueron estos:

*   Instalar el paquete net-tools
*   Instalar el paquete php7.2. Esto incluye los siguientes comandos:
    *   apt update && apt upgrade
    *   apt install apt-transport-https lsb-release ca-certificates
    *   wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
    *   echo "deb https://packages.sury.org/php/ $(lsb\_release -sc) main" > /etc/apt/sources.list.d/php.list
    *   apt update
    *   apt install php7.2
    *   apt search php7.2
    *   apt install php7.2 php7.2-cli php7.2-common php7.2-json php7.2-opcache php7.2-mysql php7.2-zip php7.2-fpm php7.2-mbstring
    *   a2dismod php7.0
    *   systemctl restart apache2
    *   a2enmod php7.2
    *   systemctl restart apache2
*   Transferencia de los archivos a través de pscp. Necesario incluir -r para la copia recursiva de los directorios, así como modificación de los permisos en linux en la carpeta de destino con _chmod 777 carpeta_.
*   Reestablecer la password de Webmin. Para ello, se necesita el siguiente comando: /usr/share/webmin/changepass.pl /etc/webmin admin newpassword
*   Reinstalar el servidor bind9 dns, ya que, por alguna razón, viene inhabilitado. Para ello, se necesita el siguiente comando: sudo apt install bind9 bind9utils bind9-doc
*   Crear una zona maestra. La nombro knt.
*   Crear un dominio: www.kontollarte.knt resuelto por la ip 10.0.2.12 (Debian9)
*   Crear un servidor virtual. Puerto 80. Dominio: el citado arriba. DirectoryRoot: /var/www/html/kontollarte/public
*   Crear la base de datos, el usuario y reestablecer la pass de phpmyamdin:
    *   mysql -u root -p
    *   CREATE USER 'newuser'@'localhost' IDENTIFIED BY 'user\_password'; **Importante el ;**
    *   GRANT ALL PRIVILEGES ON \*.\* TO 'database\_user'@'localhost';
*   Entrar al dominio por http: [http://www.kontollarte.com](http://www.kontollarte.com)

Y de forma mágica, tras estos _sencillísimos pasos_, la app está lista. O se supone, más bien, que debería estar lista. Sin embargo, lo que ocurre es que aparece un error 404 Not Found en el navegador. Investigo y resulta que es por unas directivas que han de ir en el archivo de configuración del sitio. Para ello nos vamos a la ruta _/etc/apache/sites-avialable_ y entramos a nuestro archivo de configuración para que tenga el siguiente aspecto:

No será el único cambio necesario. Las carpetas por defecto están a forbidden para el usuario, con lo que ejecuto un _chmod -R_. El parámetro -R sirve para indicar una modificación recursiva de los directorios y archivos subyacentes.

Una vez realizados estos ajustes, parece que el dominio ya funciona correctamente.

Por último, para la creación del servicio ftp se siguen los siguientes pasos:

Ejecuto _apt-get install proftpd_.

![cmd-linux](https://github.com/ivanmirandastavenuiter/kontollarte-app-laravel-production/blob/master/KONTOLLARTE_DOCS/PICS/19.PNG)

Se descarga el cliente _Filezilla_.

Creación del servidor ftp en el módulo correspondiente. Se establecen dirección, puerto y nombre.

![virtual-server](https://github.com/ivanmirandastavenuiter/kontollarte-app-laravel-production/blob/master/KONTOLLARTE_DOCS/PICS/20.PNG)

Creación del usuario virtual mediante el comando _ftpasswd_.

![ftpd](https://github.com/ivanmirandastavenuiter/kontollarte-app-laravel-production/blob/master/KONTOLLARTE_DOCS/PICS/21.PNG)

Eliminación de la restricción para logueo sin shell válida.

![not-valid-shell](https://github.com/ivanmirandastavenuiter/kontollarte-app-laravel-production/blob/master/KONTOLLARTE_DOCS/PICS/22.PNG)

Cambio de permisos mediante _chmod_ y la _uid_ del usuario.

![chmod](https://github.com/ivanmirandastavenuiter/kontollarte-app-laravel-production/blob/master/KONTOLLARTE_DOCS/PICS/23.PNG)

Enjaulamiento del usuario creado mediante la opción _Archivos y directorios_.

![chroot](https://github.com/ivanmirandastavenuiter/kontollarte-app-laravel-production/blob/master/KONTOLLARTE_DOCS/PICS/24.PNG)
