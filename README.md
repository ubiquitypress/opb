# opb
Open Practice Badges

# what?
This is a plugin for PKP's Open Journal Systems. It allows authors to claim Open Practice Badges, reviewers to review them and will display the badges alongside PDF and XML/HTML Galleys.

# how?
This project has been generously funded by the Centre for Open Science.

# who?
This plugin was developed by Andy Byers at Ubiquity Press.

# hacking?
To get started you must clone the UP OJS Fork:

```git clone https://github.com/ubiquitypress/ojs```

Our commits are on the 2.4.8 branch so you'll need to check it and the PKP lib out.

```
git checkout ojs-stable-2_4_8
cd lib/pkp
git checkout ojs-stable-2_4_8
```

we also want the PKP Library and other sub modules so cd into the repo:

```git submodule update --init --recursive```

then cd into the generic plugins folder

```cd ojs/plugins/generic/```

and clone this repo

```git clone https://github.com/ubiquitypress/opb```
