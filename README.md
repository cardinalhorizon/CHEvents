# Events
The Cardinal Horizon Events module is a phpVMS module designed to give your community the ability
to host events.
## Features
* Create Events with Name, Description, Route Code, Banner, and Start/End Date/Times
* Users can sign up or leave events
* Automatic PIREP event flight detection via Route Code
* Admin panel to edit the users and PIREPs associated with the event.
* Works with the stock phpVMS v7 theme. Files intended for a Bootstrap 5.3 compatible theme are included alongside the 
release.
## License Agreement
By downloading and running this software, you agree to the terms and conditions outlined by the Cardinal Horizon phpVMS 
Module Software License. A copy is included in this repository
## Installation
To download, go to the releases section, as seen on the right, then download the binary.

Once Downloaded, extract the module folder, with this readme included, into your phpVMS modules folder.

Once extracted, go into your phpVMS admin panel and enable the module. If the module doesn't appear, clear
your application cache under Admin > Maintenance.

Once enabled, force a update to push through the database migrations.
## Explaining Route Codes
The `Route Code` field is effectively a "discriminator" that allows for multiple flights to share the same flight number
for the same airline/operator in phpVMS. Through route codes, we can define event flights that can be flown and tracked
with the event.

It is recommended that, for using route codes, to name the route codes as something unique and have a naming scheme that
makes sense when the flight is shown alongside your other flights in your system. For example, if you were to fly
VATSIM's Cross The Pond Westbound 2024, a logical event code name could be `CTPW`.

The Route code field has a storage limit of 5 alphanumeric characters, so please note this in your files.
