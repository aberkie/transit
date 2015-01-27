# Transit
Craft CMS Plugin for use with WMATA API. 

## Install
1. Upload entire transit directory to craft/plugins on your server.
2. Navigate to your site's Plugins settings from the Control Panel.
3. Click Install.
4. Register for WMATA Developer Key (developer.wmata.com) and save the key in the plugin's settings.
5. Install Stations and Lines by clicking the "Refresh Stations" and "Refresh Lines" buttons.

![View of Transit Plugin Control Panel](/resources/screenshots/cp_panel.jpg?raw=true "Transit Plugin Control Panel")


## Field Types
Transit comes with two Field Types, Metro Stations and Metro Lines. Use them as you would any other field in Craft on any entry type.
![New field view](/resources/screenshots/new_field.jpg?raw=true "Create a new field")

## Uses
In an entry template that contains a Metro Station field, use Transit to get station information and real-time next train predictions.

### getStationInformation(stationCode)

`{% set stationInformation = craft.transit.getStationInformation(entry.yourMetroStationFieldHandle) %}`

`<h4>{{stationInformation.Name}}</h4>`

`<p>Located at {{stationInformation.Address_Street}} in {{stationInformation.Address_City}}, {{stationInformation.Address_State}}</p>`

For a Metro Station field with Dupont Circle selected, the above code will render:

#### Dupont Circle
Located at 1525 20th St. NW in Washington, DC


### getNextTrainPredictions(stationCode)

`{% set predictions = craft.transit.getNextTrains(entry.metroStation) %}

{% for prediction in predictions %}
		<p>{{prediction['Line']}} to {{prediction['Destination']}} in {{prediction['Min']}} Minutes</p>
{% endfor %}`

The above code will make an API call to WMATA and return back real-time predictions, rendering: 

RD to Grsvnor in 3 Minutes

RD to Glenmont in 6 Minutes

RD to Shady Gr in 7 Minutes

RD to SilvrSpg in 10 Minutes

RD to Grsvnor in 15 Minutes

RD to Glenmont in 16 Minutes