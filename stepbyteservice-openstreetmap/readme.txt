=== OpenStreetMap for Gutenberg and WPBakery Page Builder (formerly Visual Composer) ===
Author: Step-Byte-Service GmbH
Author URI: https://www.step-byte-service.com
Contributors: stepbyteservice
Tags: maps, openstreetmap, gutenberg, wpbakery page builder, leaflet
Requires at least: 5.2
Tested up to: 6.7
Requires PHP: 5.6
Stable tag: 1.2.0
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.txt

OpenStreetMap Gutenberg block, WPBakery PageBuilder content element and standalone WordPress shortcode

== Description ==

Add beautiful maps to your WordPress pages with ease. Customize location, map styles, up to two markers, routing and more. Include the map as Gutenberg block, WPBakery Page Builder (formerly Visual Composer) content element or shortcode.

== Installation ==

**Notes:**
* the Gutenberg block requires WordPress 5.2 or higher
* the WPBakery Page Builder content element requires an active [WPBakery Page Builder](https://wpbakery.com) plugin

1. Upload the StepByteService OpenStreetMap plugin to the '/wp-content/plugins' directory.
2. Activate the plugin.
3. Use one of the components to add maps to your pages.

== General Settings ==

This plugin comes with sane predefined settings. Adjust them to your liking. The marker is optional and is not displayed by default.

= Map Settings =
**Map Style** Choose the style of the map from one of the available map tile providers to fit your needs.
**Map Style Key** Enter an API key or access token for the provider depending on the chosen map style. Only required for some map style providers.
**Map Height in Relation to Width** Change the map's aspect ratio. Works nicely with responsive designs.
**Zoom Level** Change the view distance. The higher the number, the closer the distance to the map. (Note: not all styles support all zoom levels).
**Zoom With CTRL-Key Only** Prevent zooming during page scroll.
**Latitude/Longitude of the Map's Center** Specify the map's center position. Only needed if no marker configured or no marker is set as center of the map.
**Activate Routing** Activate route planning for the user.
**Show Attribution** Display or hide attribution for map styles and data. If you disable the checkbox please consider the legal circumstances.

= Routing Settings =
**Default Routing Destination** Enter the number of the marker that should be the default routing destination.
**Routing Service** Choose the routing service that is used for retrieving the routing information.
**Routing Key** Enter an API key or access token depending on the chosen routing service.

= Geocoding Settings =
**Geocoding Service** Choose the geocoding service that is used to translate addresses to latitude and longitude.
**Geocoding Key** Enter an API key or access token depending on the chosen geocoding service.

= Marker Settings =
**Center map on** Enter the number of the marker that should be in the center of the map.
**Determine Position By** Choose if you want to specify the marker position by an address or coordinates. The marker appears only if you specify an address or coordinates.
**Address** Insert the marker's address here with comma separated address parts (only used if you have chosen 'Address' in previous setting).
**Latitude/Longitude** Specify marker position with latitude and longitude data (only used if you have chosen 'Coordinates' in first setting).
**Icon** The icon to appear on the marker. Subset from [Material Icons](https://material.io/resources/icons/?style=outline) in outlined style (available categories: Maps, Places, Social).
**Color** Background color of the marker.
**Popup Text** Content of the popup that appears if the user clicks on the marker.

== Gutenberg ==

The block is located in the 'Embed' category and supports the wide and full width options.

== WPBakery Page Builder ==

The content element for the map can be found on the 'Content' tab with the name 'SBS OpenStreetMap'. The content element for the marker can also be found on the 'Content' tab with the name 'SBS Openstreetmap Marker' but only as child of the map element.

== Shortcodes ==

The Plugin comes with two shortcodes: `[sbs_openstreetmap]` for the map and `[sbs_marker]` for the markers (need to be placed between the opening and closing tags of the map shortcode).
If parameters are not specified, the defaults are used (the same as in the other components). The popup text for the marker can be specified between the opening and closing tags of the marker shortcode.

= Parameters Map Shortcode =
See section 'General Settings' for description. Name in parentheses is the entry there. 

**map_style** (Map Style)
Choose provider and style variant and define map_style as 'provider.variant' (eg. Thunderforest.Transport) or in case of a provider without variants just 'provider' (eg. OpenTopoMap) . (pay attention to upper and lower case)

Available Provider with Variants:
*OpenStreetMap* -- Variants: DE (default), Mapnik, France, HOT
*OpenTopoMap*
*Stadia* -- Variants: AlidadeSmooth, AlidadeSmoothDark, Outdoors, OSMBright, StamenToner, StamenTonerLite, StamenTerrain, StamenWatercolor
*Thunderforest* -- Variants: OpenCycleMap, Transport, TransportDark, SpinalMap, Landscape, Outdoors, Pioneer, MobileAtlas, Neighbourhood
*MapBox* -- Variants: Streets, Outdoors, Light, Dark, Satellite
*CartoDB* -- Variants: Positron, DarkMatter, Voyager
*MapTiler* -- Variants: Basic, Bright, Pastel, Positron, Hybrid, Streets, Toner, Topo, Voyager

For more information see section 'Map Styles'.
**map_style_key** (Map Style Key) Needed for certain map providers.
**map_height** (Map Height in Relation to Width) Use a number as percentage of the width. Default value is 50.
**zoom** (Zoom Level) Number between 0 and 20. Default value is 15.
**ctrl_mouse_zoom** (Zoom With CTRL-Key Only) Set to true or false. Default is false.
**latitude** (Latitude of the Map's Center)
**longitude** (Longitude of the Map's Center)
**routing** (Activate Routing) Set to true or false. Default is false.
**show_attribution** (Show Attribution) Set to true or false. Default is true.
**destination_marker** (Default Routing Destination) Number of the marker shortcode based on order inside the map shortcode. 0 if no marker is supposed to be the default routing destination. Default is 1.
**router** (Routing Service) Available values:
*osrmv1* (default)
*mapbox*
**router_key** (Routing Key) Needed for certain routing services.
**geocoder** (Geocoding Service) Available values:
*nominatim* (default)
*mapbox*
**geocoder_key** (Geocoding Key) Needed for certain geocoding services.
**center_marker** (Center Map on) Number of the marker shortcode based on order inside the map shortcode. 0 if no marker is supposed to be the center of the map. Default is 1.

= Parameters Marker Shortcode =
See section 'General Settings' for description. Name in parentheses is the entry there. 

**marker_source** (Determine Position By) Available values:
*address* (default)
*coordinates*
**marker_address** (Address)
**marker_latitude** (Latitude)
**marker_longitude** (Longitude)
**marker_icon** (Icon) CSS classes for the icon. Go to the Material Icon website and choose your desired icon. To get the CSS classes, use the icon's name, replace the underscore with a hyphen and prepend 'sbs-map-icon sbs-map-'. Example: icon 'local_airport' becomes 'sbs-map-icon sbs-map-local-airport'
**marker_color** (Color) Available values:
*red*
*white*
*dark_blue* (default)
*green*
*black*
*orange*
*yellow*

**Examples:**

`[sbs_openstreetmap][sbs_marker][/sbs_marker][/sbs_openstreetmap]`

Uses default values

`[sbs_openstreetmap center_marker="1"][sbs_marker marker_source="coordinates" marker_color="green" marker_latitude="52.4681196" marker_longitude="13.3279639" marker_icon="sbs-map-icon sbs-map-my-location"][/sbs_marker][/sbs_openstreetmap]`

Green marker from coordinates with my_location icon, centered map at marker and no popup text

`[sbs_openstreetmap map_style="CartoDB.Voyager" map_height="30" zoom="14" ctrl_mouse_zoom="true"][sbs_marker marker_color="dark_blue" marker_address="Bundesallee 87, 12161 Berlin" marker_icon="sbs-map-icon sbs-map-beenhere"]Popup Text[/sbs_marker][/sbs_openstreetmap]`

CartoDB Voyager style, Zoom with CTRL key only, dark blue marker from address with popup text

`[sbs_openstreetmap map_style="MapBox.Streets" map_style_key="<your access token>"][/sbs_openstreetmap]`

Mapbox Streets style that needs an access token

`[sbs_openstreetmap zoom="12" latitude="52.493558" longitude="13.375148" center_marker="0"][sbs_marker marker_address="Bundesallee 87, 12161 Berlin"]Marker 1[/sbs_marker][sbs_marker marker_address="Platz der Republik 1, 10557 Berlin"]Marker 2[/sbs_marker][/sbs_openstreetmap]`

Two markers with different addresses, center of the map somewhere in between through coordinates

== Map Styles ==

The selectable styles are offered by various providers. Each provider has its own terms of use and licensing, which should be taken into account before using the styles. (See section 'Licenses/Policies' for links)
Providers could change their terms of use or might not be available at all times (especially if they are free/ without registration).

= Providers =

**OpenStreetMap**
Usable without registration.
*Variants:* DE, Mapnik, France, HOT
Examples: [DE](https://www.openstreetmap.de/karte.html), [Mapnik](https://www.openstreetmap.org/#map=6/55.801/22.126), [France](http://tile.openstreetmap.fr/), [HOT](https://www.openstreetmap.org/#map=6/55.179/22.830&layers=H)
*Tiles:*
* DE: https://tile.openstreetmap.de/{z}/{x}/{y}.png
* Mapnik: https://tile.openstreetmap.org/{z}/{x}/{y}.png
* France: https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png
* HOT: https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png
*Attributions:*
* DE, Mapnik: &copy; [OpenStreetMap](https://www.openstreetmap.org/copyright) contributors
* France: &copy; OpenStreetMap France | &copy; [OpenStreetMap](https://www.openstreetmap.org/copyright) contributors
* HOT: &copy; [OpenStreetMap](https://www.openstreetmap.org/copyright) contributors, Tiles style by [Humanitarian OpenStreetMap Team](https://www.hotosm.org/) hosted by [OpenStreetMap France](https://openstreetmap.fr/)

**OpenTopoMap**
Usable without registration.
[Example](https://opentopomap.org/#map=6/49.532/16.194)
*Tiles:*
* https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png
*Attributions:*
* Map data: &copy; [OpenStreetMap](https://www.openstreetmap.org/copyright) contributors, [](http://viewfinderpanoramas.org) | Map style: &copy; [OpenTopoMap](https://opentopomap.org) \([CC-BY-SA](https://creativecommons.org/licenses/by-sa/3.0/)\)

**Stadia**
In order to use Stadia maps, you must [register](https://client.stadiamaps.com/signup/) and whitelist your domain within your account. Map styles from Stamen are now included in Stadia.
*Variants:* AlidadeSmooth, AlidadeSmoothDark, Outdoors, OSMBright, StamenToner, StamenTonerLite, StamenTerrain, StamenWatercolor
[Examples](https://docs.stadiamaps.com/themes/)
*Tiles:*
* https://tiles.stadiamaps.com/tiles/{variant}/{z}/{x}/{y}{r}.{ext}
*Attributions:*
* Stamen: &copy; [Stadia Maps](https://www.stadiamaps.com/) &copy; [Stamen Design](https://www.stamen.com/) &copy; [OpenMapTiles](https://openmaptiles.org/) &copy; [OpenStreetMap](https://www.openstreetmap.org/copyright) contributors
* Other: &copy; [Stadia Maps](https://www.stadiamaps.com/) &copy; [OpenMapTiles](https://openmaptiles.org/) &copy; [OpenStreetMap](https://www.openstreetmap.org/copyright) contributors

**Thunderforest**
In order to use Thunderforest maps, you must [register](https://www.thunderforest.com/pricing/). Once registered, you get an API key to use for the map styles.
*Variants:* OpenCycleMap, Transport, TransportDark, SpinalMap, Landscape, Outdoors, Pioneer, MobileAtlas, Neighbourhood
[Examples](https://www.thunderforest.com/maps/)
*Tiles:*
* https://{s}.tile.thunderforest.com/{variant}/{z}/{x}/{y}.png?apikey={apikey}
*Attributions:*
* &copy; [Thunderforest](http://www.thunderforest.com/), &copy; [OpenStreetMap](https://www.openstreetmap.org/copyright) contributors

**MapBox**
In order to use MapBox maps, you must [register](https://account.mapbox.com/auth/signup/). Once registered, you get an access token to use for the map styles.
*Variants:* Streets, Outdoors, Light, Dark, Satellite
[Examples](https://www.mapbox.com/maps)
*Tiles:*
* https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}{r}?access_token={accessToken}
*Attributions:*
* &copy; [Mapbox](https://www.mapbox.com/about/maps/) &copy; [OpenStreetMap](https://www.openstreetmap.org/copyright) contributors [Improve this map]("https://www.mapbox.com/map-feedback/)

**CartoDB**
Basemaps are usable without registration.
*Variants:* Positron, DarkMatter, Voyager
[Examples](https://carto.com/help/building-maps/basemap-list/)
*Tiles:*
* https://{s}.basemaps.cartocdn.com/{variant}/{z}/{x}/{y}{r}.png
*Attributions:*
* &copy; [OpenStreetMap](https://www.openstreetmap.org/copyright) contributors [CARTO](https://carto.com/attributions)

**MapTiler**
In order to use MapTiler maps, you must [register](https://cloud.maptiler.com/auth/widget?mode=select&next=https%3A%2F%2Fcloud.maptiler.com%2Fstart). Once registered, you get an API key to use for the map styles.
*Variants:* Basic, Bright, Pastel, Positron, Hybrid, Streets, Toner, Topo, Voyager
[Examples](https://www.maptiler.com/maps/#streets/raster/1/2.3/8.2)
*Tiles:*
* https://api.maptiler.com/maps/{variant}/{z}/{x}/{y}{r}.{ext}?key={key}
*Attributions:*
* [&copy; MapTiler]("https://www.maptiler.com/copyright/) [&copy; OpenStreetMap contributors](https://www.openstreetmap.org/copyright)

= Deprecated =
These values are deprecated and will be mapped onto the corresponding new values for the same map style.
*openstreetmap_de*
*opentopomap*
*stamen_toner*
*stamen_toner_light*
*stamen_terrain*
*stamen_watercolor*
*wikimedia* (not available anymore and if set in map, will be replaced with OpenStreetMap.DE)

== Licenses/Policies ==

= External Services =
**Provides the map data**
OpenStreetMap [ODbL](https://www.openstreetmap.org/copyright)
**Providers for routing**
OSRM Demo Server [Usage policy](https://github.com/Project-OSRM/osrm-backend/wiki/Api-usage-policy)
Mapbox [Terms of service](https://www.mapbox.com/legal/tos/)
**Providers for geocoding**
Nominatim [Usage policy](https://operations.osmfoundation.org/policies/nominatim/)
Mapbox [Terms of service](https://www.mapbox.com/legal/tos/)
**Providers used for choosable map styles**
OpenStreetMap [Terms of use](https://operations.osmfoundation.org/policies/tiles/)
OpenTopoMap [CC-BY-SA/Terms of use](https://opentopomap.org/about)
Stadia [Terms of use](https://stadiamaps.com/terms-of-service/)
Thunderforest [Terms of use](https://www.thunderforest.com/terms/)
MapBox [Terms of use](https://www.mapbox.com/legal/tos/)
CartoDB [Terms of use](https://carto.com/legal/)
MapTiler [Terms of use](https://www.maptiler.com/cloud/terms/)

= Third-Party Components =
[Leaflet JS](https://leafletjs.com/) [BSD 2-Clause "Simplified" License](https://github.com/Leaflet/Leaflet/blob/master/LICENSE)
Leaflet.GestureHandling [MIT License](https://github.com/elmarquis/Leaflet.GestureHandling/blob/master/LICENSE)
Leaflet-providers [BSD 2-Clause "Simplified" License](https://github.com/leaflet-extras/leaflet-providers/blob/master/license.md)
Leaflet-control-geocoder [BSD 2-Clause "Simplified" License](https://github.com/perliedman/leaflet-control-geocoder/blob/master/LICENSE)
Leaflet-routing-machine [ISC License](https://github.com/perliedman/leaflet-routing-machine/blob/master/LICENSE.md)

== Screenshots ==

1. Multiple map styles
2. WPBakery Page Builder
3. Gutenberg

== Frequently Asked Questions ==

= The map does not show properly =

Wikimedia changed its terms of use and is not available as provider anymore. If the chosen map style was wikimedia it is automatically changed to OpenStreetMap.De. You can always choose a different style.

If there are graphical errors, first check if a different zoom level changes anything. Not all map styles support all zoom levels and while most should just show a different zoom level if they don't support the chosen one, there might be parts of the map which are not shown on other styles.
In case the map is placed on a container that is not visible initially (f.e. using tabs or accordions), you'll have to trigger the event `invalidate.sbs.openstreetmap` in JavaScript once the element becomes visible to redraw the map. If you're using Bootstrap or WP Bakery Page Builder tabs or accordions, this is handled by the plugin itself.

== Changelog ==

= 1.2.0 =
* JavaScript refactored
* Build adjusted
* Changed font icon picker for Gutenberg block
* Various fixes
* Changed Stamen tiles to Stadia

= 1.1.3 =
* Fixed library leftover

= 1.1.2 =
* Fixed escaping

= 1.1.1 =
* Fixed Gutenberg Migration

= 1.1.0 =
* Removed params api_key and access_token in favor of new param map_style_key
* Added routing option
* Added geocoding option
* Added support for up to 2 markers
* Updated dependencies
* Fixed error with widget editor
* Reduced amount of geocoding requests in gutenberg editor

= 1.0.10 =
* Added new provider options
* Removed Wikimedia map style

= 1.0.9 =
* Updated dependencies

= 1.0.8 =
* Wikimedia map style not default anymore

= 1.0.7 =
* Fixed check for WPBakery Page Builder events

= 1.0.6 =
* Fixed marker

= 1.0.5 =
* Internet Explorer 11 fixes

= 1.0.4 =
* Fixed marker icon selection in WPBakery Page Builder backend editor

= 1.0.3 =
* Fixed notice in WordPress debug mode

= 1.0.2 =
* Improved asset loading
* Fixed WPBakery Page Builder frontend editing

= 1.0.0 =
* Initial release