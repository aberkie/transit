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
Station information is stored in the Craft database for performance and to save API calls, but the structure of the data just matches the [API structure](https://developer.wmata.com/docs/services/5476364f031f590f38092507/operations/5476364f031f5909e4fe3310), with the exception of the address fields.

Available fields and descriptions*:
* Address_City
* Address_State
* Address_Street
* Address_Zip
* Code - this represents the unique station code used throughout the WMATA API.
* Lat - Latitude of station
* LineCode1 - Two-letter abbreviation for the line (e.g.: RD, BL, YL, OR, GR, or SV) served by this station.
* LineCode2 - Additional line served by this station. This is often the case when stations have multiple platforms (e.g.: Gallery Place, Fort Totten, L'Enfant Plaza, and Metro Center).
* LineCode3 - Similar to function as LineCodeX.
* LineCode4 - Similar to function as LineCodeX. Currently not in use.
* Lon - Longitude of station
* Name
* StationTogether1 - For stations with multiple platforms (e.g.: Gallery Place, Fort Totten, L'Enfant Plaza, and Metro Center), the additional StationCode will be listed here.
* StationTogether2 - Similar in function to StationTogether2. Currently not in use.

*Descriptions taken from [WMATA API Documentation](https://developer.wmata.com/docs/services/5476364f031f590f38092507/operations/5476364f031f5909e4fe330c).

`{% set stationInformation = craft.transit.getStationInformation(entry.yourMetroStationFieldHandle) %}`

`<p><strong>{{stationInformation.Name}}</strong> - Located at {{stationInformation.Address_Street}} in {{stationInformation.Address_City}}, {{stationInformation.Address_State}}.</p>`

For a Metro Station field with Dupont Circle selected, the above code will render:

**Dupont Circle** - Located at 1525 20th St. NW in Washington, DC.


### getNextTrains(stationCode)
Use this function go get real-time train predictions from WMATA. 
An array of train predictions is returned with the following fields per prediction*:

* Car - Number of cars on a train, usually 6 or 8, but might also return - or NULL.
* Destination - Abbreviated version of the final destination for a train. This is similar to what is displayed on the signs at stations.
* DestinationCode - Destination station code. Can be NULL. Use this value in other rail-related APIs to retrieve data about a station.
* DestinationName - When DestinationCode is populated, this is the full name of the destination station, as shown on the WMATA website.
* Group - Denotes the track this train is on, but does not necessarily equate to Track 1 or Track 2. With the exception of terminal stations, predictions at the same station with different Group values refer to trains on different tracks.
* Line - Two-letter abbreviation for the line (e.g.: RD, BL, YL, OR, GR, or SV). May also be blank or No for trains with no passengers.
* LocationCode - Station code for where the train is arriving. Use this value in other rail-related APIs to retrieve data about a station.
* LocationName - Full name of the station where the train is arriving. Useful when passing in All as the StationCodes parameter.
* Min - Minutes until arrival. Can be a numeric value, ARR (arriving), BRD (boarding), or ---.

*Descriptions taken from [WMATA API Documentation](https://developer.wmata.com/docs/services/547636a6f9182302184cda78/operations/547636a6f918230da855363f).

Results are cached for 30 seconds to reduce the number of API calls.


`{% set predictions = craft.transit.getNextTrains(entry.metroStation) %}`

`% for prediction in predictions %}`

`<p>{{prediction['Line']}} to {{prediction['Destination']}} in {{prediction['Min']}} Minutes</p>`
	
`{% endfor %}`

The above code will render: 

RD to Grsvnor in 3 Minutes

RD to Glenmont in 6 Minutes

RD to Shady Gr in 7 Minutes

RD to SilvrSpg in 10 Minutes
