![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)
[![Chat](https://img.shields.io/discord/620935790867906561?label=chat)](https://discord.gg/YeJBQrTUT9)
![HitCount](https://views.whatilearened.today/views/github/keizah7/laravel-youtube-videos-list.svg)
![Forks](https://img.shields.io/github/forks/keizah7/laravel-youtube-videos-list?style=social)
![Stars](https://img.shields.io/github/stars/keizah7/laravel-youtube-videos-list?style=social)
![Watchers](https://img.shields.io/github/watchers/keizah7/laravel-youtube-videos-list?style=social)
![Contributors](https://img.shields.io/github/contributors/keizah7/laravel-youtube-videos-list)
## Youtube videos list

#### Panaudojant Laravel 5+ ir VueJS įgyvendinti šiuos punktus:
1. Sukurti vartotojo login/registracijos formą:
    1. Turi būti galimybė pasirinkti userio rolę:
        - agent
        - teamleader.
1. Duomenis talpinti `SQL` tipo duomenų bazėje. 
1. Iš youtube.com ištraukti video duomenis:
    1. Teamleader tipo vartotojas turi turėti galimybę pridėti prie savo paskyros Youtube klipus ir jų informaciją gautą per `Youtube API`.
1. Atvaizduoti video sąrašą:
    1. Vartotojas `agent` turi matyti visų ištrauktų klipų lentelę (pagalvoti apie duomenų kešavimą).

## Installation
Run these commands in command prompt:
```
git clone https://github.com/keizah7/laravel-youtube-videos-list.git your-folder
cd your-folder
composer install
npm install
```
Create ``.env`` file from ``.env.example``

Run ``php artisan key:generate`` and the fill data in ``.env`` file:
```
MIX_SENTRY_DSN_PUBLIC=http://localhost/your-folder/public
DB_DATABASE=database-name
DB_USERNAME=database-user
DB_PASSWORD=database-pass

YOUTUBE_API_KEY=youtube-api-key
OAUTH2_CLIENT_ID=google-oauth2-client-id
OAUTH2_CLIENT_SECRET=google-oauth2-client-seret
```
You can get API keys in [Google APIs](https://.developers.google.com).

Authorized redirect URIs: ``http://localhost/your-folder/public/youtube/callback``

And, finally: run
```
php artisan migrate:fresh --seed
npm run dev
```

#### Author: [Artūras](https://github.com/keizah7) ![Followers](https://img.shields.io/github/followers/keizah7?style=social)
