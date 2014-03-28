### First screen

1) "Your photo hosting". Radio button:

- flickr
- instagram

2) "Authorisation". Textfields:

- login
- password

3) "Connect to my photo hosting". Button.

After submitting we connect to image hosting and get accessible info:

- album names (+ count of photos in every album)
- photos list with dates. If there are ```count(photos) > max_limit``` --> get dates of the first and last photos.

### Second screen

1) "Which personal photos to use?". Checkboxes set:

- list of all albums
- list of years

2) "To correlate with". Checkboxes:

- Monet
- Renaissance

Here can be a great variety of opportunities. For prototype start with this two.

3) "Get new vision"


After submitting:

- browser sends data to the server
- server application connects to photo hosting
- app gets necessary personal data and processing 
- app gets necessary prepared data from storage about Classic Painters
- app sends it all to browser

### Third screen

Now browser has all data from server  (json?) and renders it (dart).
Person may change:

- type of vision - square, diagrams, circle or something else
- how personal data correlate with Classic Painters' data

This manipulation are local - no request to server.
Persons can save images right in their photo hosting.