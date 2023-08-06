ドキュメント準備中...

database/migrationsまだ作れてないですごめんなさい...
とりあえずdocuments/db-structuresにほぼ完全版の設計書があるので参考にしてください。

# セットアップ方法
- `make init` docker-compose経由でセットアップを開始します。
- `make reinit` .envの生成を除くセットアップ手順をdocker-compose経由で再実行します。
- `make init-staging` サーバー上に直接展開します。
- `make migrate` docker-compose経由でシステムのアップデート処理を行います。
- `make migrate-staging` システムのアップデート処理をサーバー上で直接行います。
- `make start-service` docker-compose経由で、常駐サービスを開始します。

[//]: # (<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>)

[//]: # ()
[//]: # (<p align="center">)

[//]: # (<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>)

[//]: # (<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>)

[//]: # (<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>)

[//]: # (<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>)

[//]: # (</p>)

[//]: # ()
[//]: # (## About Laravel)

[//]: # ()
[//]: # (Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:)

[//]: # ()
[//]: # (- [Simple, fast routing engine]&#40;https://laravel.com/docs/routing&#41;.)

[//]: # (- [Powerful dependency injection container]&#40;https://laravel.com/docs/container&#41;.)

[//]: # (- Multiple back-ends for [session]&#40;https://laravel.com/docs/session&#41; and [cache]&#40;https://laravel.com/docs/cache&#41; storage.)

[//]: # (- Expressive, intuitive [database ORM]&#40;https://laravel.com/docs/eloquent&#41;.)

[//]: # (- Database agnostic [schema migrations]&#40;https://laravel.com/docs/migrations&#41;.)

[//]: # (- [Robust background job processing]&#40;https://laravel.com/docs/queues&#41;.)

[//]: # (- [Real-time event broadcasting]&#40;https://laravel.com/docs/broadcasting&#41;.)

[//]: # ()
[//]: # (Laravel is accessible, powerful, and provides tools required for large, robust applications.)

[//]: # ()
[//]: # (## Learning Laravel)

[//]: # ()
[//]: # (Laravel has the most extensive and thorough [documentation]&#40;https://laravel.com/docs&#41; and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.)

[//]: # ()
[//]: # (If you don't feel like reading, [Laracasts]&#40;https://laracasts.com&#41; can help. Laracasts contains over 1100 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost you and your team's skills by digging into our comprehensive video library.)

[//]: # ()
[//]: # (## Laravel Sponsors)

[//]: # ()
[//]: # (We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page]&#40;https://patreon.com/taylorotwell&#41;.)

[//]: # ()
[//]: # (- **[Vehikl]&#40;https://vehikl.com/&#41;**)

[//]: # (- **[Tighten Co.]&#40;https://tighten.co&#41;**)

[//]: # (- **[Kirschbaum Development Group]&#40;https://kirschbaumdevelopment.com&#41;**)

[//]: # (- **[64 Robots]&#40;https://64robots.com&#41;**)

[//]: # (- **[Cubet Techno Labs]&#40;https://cubettech.com&#41;**)

[//]: # (- **[Cyber-Duck]&#40;https://cyber-duck.co.uk&#41;**)

[//]: # (- **[British Software Development]&#40;https://www.britishsoftware.co&#41;**)

[//]: # (- **[Webdock, Fast VPS Hosting]&#40;https://www.webdock.io/en&#41;**)

[//]: # (- **[DevSquad]&#40;https://devsquad.com&#41;**)

[//]: # (- [UserInsights]&#40;https://userinsights.com&#41;)

[//]: # (- [Fragrantica]&#40;https://www.fragrantica.com&#41;)

[//]: # (- [SOFTonSOFA]&#40;https://softonsofa.com/&#41;)

[//]: # (- [User10]&#40;https://user10.com&#41;)

[//]: # (- [Soumettre.fr]&#40;https://soumettre.fr/&#41;)

[//]: # (- [CodeBrisk]&#40;https://codebrisk.com&#41;)

[//]: # (- [1Forge]&#40;https://1forge.com&#41;)

[//]: # (- [TECPRESSO]&#40;https://tecpresso.co.jp/&#41;)

[//]: # (- [Runtime Converter]&#40;http://runtimeconverter.com/&#41;)

[//]: # (- [WebL'Agence]&#40;https://weblagence.com/&#41;)

[//]: # (- [Invoice Ninja]&#40;https://www.invoiceninja.com&#41;)

[//]: # (- [iMi digital]&#40;https://www.imi-digital.de/&#41;)

[//]: # (- [Earthlink]&#40;https://www.earthlink.ro/&#41;)

[//]: # (- [Steadfast Collective]&#40;https://steadfastcollective.com/&#41;)

[//]: # (- [We Are The Robots Inc.]&#40;https://watr.mx/&#41;)

[//]: # (- [Understand.io]&#40;https://www.understand.io/&#41;)

[//]: # (- [Abdel Elrafa]&#40;https://abdelelrafa.com&#41;)

[//]: # ()
[//]: # (## Contributing)

[//]: # ()
[//]: # (Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation]&#40;https://laravel.com/docs/contributions&#41;.)

[//]: # ()
[//]: # (## Security Vulnerabilities)

[//]: # ()
[//]: # (If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com]&#40;mailto:taylor@laravel.com&#41;. All security vulnerabilities will be promptly addressed.)

[//]: # ()
[//]: # (## License)

[//]: # ()
[//]: # (The Laravel framework is open-source software licensed under the [MIT license]&#40;https://opensource.org/licenses/MIT&#41;.)
