# AstroGenesis

AstroGenesis is a web game that recreates the experience of the popular game "OGame" using the Laravel framework.

## Description

AstroGenesis is an ongoing development project that aims to provide a similar experience to the game OGame. The main objective of the game is to build and expand a space empire, explore systems and planets, research technologies, and compete with other players.

## Features
Manage your planet:
- Upgrade mining facilities to earn more resources (/)
- Build logistics buildings (WIP)
- Build defenses (WIP)

Fleet:
- Build your fleet (/)
- Send your fleets on resource expeditions (/)
- Spy on other planets (/)
- Attack other planets (WIP)
- Collaborate with other planets (WIP)

Other:
- Implement functional AI (WIP)
- Improve expeditions (WIP)
- Improve HUD (WIP)

## Technologies used

- Laravel: PHP framework for backend development.
- JavaScript (Ajax): used for interactivity and real-time updates.
- HTML (Blade): view templates using the Laravel template engine.
- CSS (SASS): game styles and design.
- MySQL: relational database management system.

## Installation

1. Clone this repository: `git clone https://github.com/DavidHern0/AstroGenesis.git`.

2. Navigate to the project directory: `cd .\AstroGenesis\`.

3. Install project dependencies: `composer install`.

4. Configure the environment file: duplicate the .env.example file and rename it to .env. Adjust the configuration as needed.

5. Generate an application key: `php artisan key:generate`.

6. Run migrations and seeders: `php artisan migrate --seed`.

## Initialization

1. Start the server: `php artisan serve`.

2. Open a new Terminal to run all CRONS: `php artisan schedule:work`.

3. Access AstroGenesis in your browser: `http://localhost:8000`.

4. Play!

## Author

Name: David Hernández Larrea

Contact: dhernandezla0@gmail.com

## License

This project is under the BSD License. Refer to the LICENSE file for more information.
