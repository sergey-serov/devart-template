### First screen

1) "Your photo hosting". Radio button:

- flickr
- instagram

2) "Authorisation". Textfields:

- login
- password

3) "Connect to my photo hosting". Button.

After submit we connect to image hosting and get accessible info:

- album names (+ count photos in every album)
- photos list with dates. If there are ```count(photos) > max_limit``` --> get dates of the first and last photos.

### Second screen

1) "Which personal photos use?". Checkboxes set:

- list of all albums
- list of years

2) "To correlate with". Checkboxes:

- Monet
- Renaissance

Great variety options here can be. For prototype start with this two.

3) "Get new vision"


After submit:

- browser send data to the server
- server application connects to photo hosting
- app get necessary personal data and processing 
- app get necessary prepared data from storage about Classic Painters
- app send it all to browser

### Third screen

Browser have all data (json?) and render it (dart).
Person may change:

- type of vision - square, diagrams, circle or something else
- how to correlate personal data with Classic Painters data

This manipulation are local - no request to server.
Persons can save images right in their photo hosting.