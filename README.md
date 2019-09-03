# biz.jmaconsulting.multilingualmailing

![Screenshot](/images/screenshot.png)

(*FIXME: In one or two paragraphs, describe what the extension does and why one would download it. *)

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Requirements

* PHP v7.0+
* CiviCRM (*FIXME: Version number*)

## Installation (Web UI)

This extension has not yet been published for installation via the web UI.

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl biz.jmaconsulting.multilingualmailing@https://github.com/FIXME/biz.jmaconsulting.multilingualmailing/archive/master.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/FIXME/biz.jmaconsulting.multilingualmailing.git
cv en multilingualmailing
```

## Usage

##### Creating the translated mailing

1. Create a new mailing, and select the language used for the mailing (This will normally be the french version of the email). DO NOT select any value in the "Alternative Language Mailing" selectbox.

##### Creating the original mailing

1. Create a new mailing or re-use an existing one.
2. Select the mailing created above from the "Alternative Language Mailing" dropdown.
3. In place of the "View in Browser" mailing token, use the "Translated Mailing Link" token to show two links, first containing link to public view for original mailing, and second containing link to public view for translated mailing.
4. Set the language for the created mailing to "English" (different than the one created above).

## Known Issues

(* FIXME *)
