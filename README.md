website
---

Building a new online presence and experience for the Ramblin' Reck Club at Georgia Tech. You can view the old one at https://reckclub.org.

## Installation
* Clone this repo.
* `cd` into this repo's root directory.
* Run `npm install`.
* Create a [Firebase](https://firebase.google.com) account and app. 
* Create a `.env` file using `.env.example` and the information it requires from Firebase.
* If you want to include the Reck history site: 
    - Clone the [repo](https://github.com/RamblinReckClub/reckhistory)
    - `cd` into the `reckhistory` directory and run `jekyll serve` to generate the `_site` folder. Make sure to quit the Jekyll server before moving on; the ports used for Jekyll and NPM could conflict.
    - Update the `_site` folder in the `update-history` command in this repo's `package.json`.
    - Run `npm run update-history` in this repo's directory.
* Run `bin/www` to start the server. 
* Navigate to `localhost:3000` to see the site.

## Roadmap
- [X] Finish the public frontend.
- [ ] Integrate user authentication with Firebase.
- [ ] Create an events/points management system/API.
- [ ] Import existing web data into Firebase.

# License
Navigate to [LICENSE.md](https://github.com/RamblinReckClub/website/blob/master/LICENSE.md) to learn more. 