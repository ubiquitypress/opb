# opb
Open Practice Badges

To get started you must clone the UP OJS Fork:

```git clone https://github.com/ubiquitypress/ojs```

we also want the PKP Library and other sub modules so cd into the repo:

```git submodule update --init --recursive```

Our commits are on the 2.4.6 branch so you'll need to check it and the PKP lib out.

```
git checkout ojs-stable-2_4_6
cd lib/pkp
git checkout ojs-stable-2_4_6
```

then cd into the generic plugins folder

```cd ojs/plugins/generic/```

and clone this repo

```git clone https://github.com:ubiquitypress/opb.git```
