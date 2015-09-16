<?php

namespace voku\helper;

/**
 * E-Mail Check Class
 *
 * -> use "EmailCheck::isValid()" to validate a email-address
 *
 * @author      Lars Moelleken
 * @copyright   Copyright (c) 2015, Lars Moelleken (http://moelleken.org/)
 * @license     http://opensource.org/licenses/MIT	MIT License
 */
class EmailCheck
{

  /*
   * The regex below is based on a regex by Michael Rushton.
   * However, it is not identical.  I changed it to only consider routeable
   * addresses as valid.  Michael's regex considers a@b a valid address
   * which conflicts with section 2.3.5 of RFC 5321 which states that:
   *
   *   Only resolvable, fully-qualified domain names (FQDNs) are permitted
   *   when domain names are used in SMTP.  In other words, names that can
   *   be resolved to MX RRs or address (i.e., A or AAAA) RRs (as discussed
   *   in Section 5) are permitted, as are CNAME RRs whose targets can be
   *   resolved, in turn, to MX or address RRs.  Local nicknames or
   *   unqualified names MUST NOT be used.
   *
   * This regex does not handle comments and folding whitespace.  While
   * this is technically valid in an email address, these parts aren't
   * actually part of the address itself.
   *
   * Michael's regex carries this copyright:
   *
   * Copyright © Michael Rushton 2009-10
   * http://squiloople.com/
   * Feel free to use and redistribute this code. But please keep this copyright notice.
   *
   * source: http://lxr.php.net/xref/PHP_5_4/ext/filter/logical_filters.c#529
   */
  const EMAIL_REGEX_LOCAL  = '(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*';
  const EMAIL_REGEX_DOMAIN = '(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))';

  public static $domainsExample = array(
      'test.de',
      'test.com',
      'test.net',
      'test.org',
      'example.de',
      'example.com',
      'example.net',
      'example.org',
  );

  /**
   * @var array
   *
   * here you can find more domains:
   * - https://github.com/vboctor/disposable_email_checker
   * - https://gist.github.com/michenriksen/8710649
   */
  public static $domainsTemporary = array(
      '0-mail.com',
      '0815.ru',
      '0815.ru0clickemail.com',
      '0clickemail.com',
      '0wnd.net',
      '0wnd.org',
      '10minutemail.com',
      '10minutemail.co.za',
      '20minutemail.com',
      '2prong.com',
      '30minutemail.com',
      '33mail.com',
      '3d-painting.com',
      '4warding.com',
      '4warding.net',
      '4warding.org',
      '60minutemail.com',
      '675hosting.com',
      '675hosting.net',
      '675hosting.org',
      '6paq.com',
      '6url.com',
      '75hosting.com',
      '75hosting.net',
      '75hosting.org',
      '7tags.com',
      '9ox.net',
      'a-bc.net',
      'afrobacon.com',
      'ag.us.to',
      'ajaxapp.net',
      'amilegit.com',
      'amiri.net',
      'amiriindustries.com',
      'anonbox.net',
      'anonymbox.com',
      'antichef.com',
      'antichef.net',
      'antispam.de',
      'armyspy.com',
      'atvclub.msk.ru',
      'azmeil.tk',
      'baxomale.ht.cx',
      'beefmilk.com',
      'binkmail.com',
      'bio-muesli.net',
      'bobmail.info',
      'bodhi.lawlita.com',
      'bofthew.com',
      'bootybay.de',
      'boun.cr',
      'bouncr.com',
      'brefmail.com',
      'broadbandninja.com',
      'bsnow.net',
      'bu.mintemail.com',
      'bugmenot.com',
      'bumpymail.com',
      'casualdx.com',
      'centermail.com',
      'centermail.net',
      'chogmail.com',
      'choicemail1.com',
      'consumerriot.com',
      'cool.fr.nf',
      'correo.blogos.net',
      'cosmorph.com',
      'courriel.fr.nf',
      'courrieltemporaire.com',
      'crazymailing.com',
      'cubiclink.com',
      'curryworld.de',
      'cust.in',
      'cuvox.de',
      'dacoolest.com',
      'dandikmail.com',
      'dayrep.com',
      'deadaddress.com',
      'deadspam.com',
      'despam.it',
      'despammed.com',
      'devnullmail.com',
      'dfgh.net',
      'digitalsanctuary.com',
      'dingbone.com',
      'discardmail.com',
      'discardmail.de',
      'disposableaddress.com',
      'disposableemailaddresses.com',
      'disposeamail.com',
      'disposemail.com',
      'dispostable.com',
      'dm.w3internet.co.uk',
      'dm.w3internet.co.ukexample.com',
      'dodgeit.com',
      'dodgit.com',
      'dodgit.org',
      'doiea.com',
      'donemail.ru',
      'dontreg.com',
      'dontsendmespam.de',
      'drdrb.com',
      'drdrb.net',
      'dump-email.info',
      'dumpandjunk.com',
      'dumpmail.de',
      'dumpyemail.com',
      'e-mail.com',
      'e4ward.com',
      'easytrashmail.com',
      'einrot.com',
      'email.net',
      'email60.com',
      'emaildienst.de',
      'emailias.com',
      'emailigo.de',
      'emailinfive.com',
      'emailmiser.com',
      'emailsensei.com',
      'emailtemporario.com.br',
      'emailto.de',
      'emailwarden.com',
      'emailx.at.hm',
      'emailxfer.com',
      'emeil.in',
      'emeil.ir',
      'emz.net',
      'enterto.com',
      'ephemail.net',
      'etranquil.com',
      'etranquil.net',
      'etranquil.org',
      'evopo.com',
      'explodemail.com',
      'fakeinbox.com',
      'fakeinformation.com',
      'fansworldwide.de',
      'fastacura.com',
      'fastchevy.com',
      'fastchrysler.com',
      'fastkawasaki.com',
      'fastmazda.com',
      'fastmitsubishi.com',
      'fastnissan.com',
      'fastsubaru.com',
      'fastsuzuki.com',
      'fasttoyota.com',
      'fastyamaha.com',
      'filzmail.com',
      'fixmail.tk',
      'fizmail.com',
      'fleckens.hu',
      'fr33mail.info',
      'frapmail.com',
      'front14.org',
      'fudgerub.com',
      'fux0ringduh.com',
      'garliclife.com',
      'gelitik.in',
      'get1mail.com',
      'get2mail.fr',
      'getairmail.com',
      'getonemail.com',
      'getonemail.net',
      'ghosttexter.de',
      'girlsundertheinfluence.com',
      'gishpuppy.com',
      'goemailgo.com',
      'gowikibooks.com',
      'gowikicampus.com',
      'gowikicars.com',
      'gowikifilms.com',
      'gowikigames.com',
      'gowikimusic.com',
      'gowikinetwork.com',
      'gowikitravel.com',
      'gowikitv.com',
      'great-host.in',
      'greensloth.com',
      'grr.la',
      'gsrv.co.uk',
      'guerillamail.biz',
      'guerillamail.com',
      'guerillamail.net',
      'guerillamail.org',
      'guerrillamail.biz',
      'guerrillamail.com',
      'guerrillamail.de',
      'guerrillamail.net',
      'guerrillamail.org',
      'guerrillamailblock.com',
      'gustr.com',
      'h.mintemail.com',
      'h8s.org',
      'haltospam.com',
      'hatespam.org',
      'hidemail.de',
      'hidzz.com',
      'hochsitze.com',
      'hotpop.com',
      'hulapla.de',
      'ieatspam.eu',
      'ieatspam.info',
      'ieh-mail.de',
      'ihateyoualot.info',
      'iheartspam.org',
      'imails.info',
      'inbax.tk',
      'inbox.si',
      'inbox2.info',
      'inboxalias.com',
      'inboxclean.com',
      'inboxclean.org',
      'incognitomail.com',
      'incognitomail.net',
      'incognitomail.org',
      'insorg-mail.info',
      'ipoo.org',
      'irish2me.com',
      'iwi.net',
      'jetable.com',
      'jetable.fr.nf',
      'jetable.net',
      'jetable.org',
      'jnxjn.com',
      'jourrapide.com',
      'junk1e.com',
      'kasmail.com',
      'kaspop.com',
      'keepmymail.com',
      'killmail.com',
      'killmail.net',
      'kir.ch.tc',
      'klassmaster.com',
      'klassmaster.net',
      'klzlk.com',
      'koszmail.pl',
      'kulturbetrieb.info',
      'kurzepost.de',
      'letthemeatspam.com',
      'lhsdv.com',
      'lifebyfood.com',
      'link2mail.net',
      'litedrop.com',
      'lol.ovpn.to',
      'lookugly.com',
      'lopl.co.cc',
      'lortemail.dk',
      'lr78.com',
      'm4ilweb.info',
      'ma1l.bij.pl',
      'maboard.com',
      'mail-temporaire.fr',
      'mail.by',
      'mail.mezimages.net',
      'mail2rss.org',
      'mail333.com',
      'mail4trash.com',
      'mailbidon.com',
      'mailblocks.com',
      'mailcatch.com',
      'maildrop.cc',
      'maileater.com',
      'mailed.in',
      'mailexpire.com',
      'mailfa.tk',
      'mailfreeonline.com',
      'mailimate.com',
      'mailin8r.com',
      'mailinater.com',
      'mailinator.com',
      'mailinator.net',
      'mailinator2.com',
      'mailincubator.com',
      'mailismagic.com',
      'mailme.ir',
      'mailme.lv',
      'mailmetrash.com',
      'mailmoat.com',
      'mailnator.com',
      'mailnesia.com',
      'mailnull.com',
      'mailshell.com',
      'mailsiphon.com',
      'mailslite.com',
      'mailtemp.info',
      'mailtothis.com',
      'mailzilla.com',
      'mailzilla.org',
      'mbx.cc',
      'mega.zik.dj',
      'meinspamschutz.de',
      'meltmail.com',
      'messagebeamer.de',
      'mierdamail.com',
      'mintemail.com',
      'mjukglass.nu',
      'mobi.web.id',
      'moburl.com',
      'moncourrier.fr.nf',
      'monemail.fr.nf',
      'monmail.fr.nf',
      'monumentmail.com',
      'msa.minsmail.com',
      'mt2009.com',
      'mt2014.com',
      'mx0.wwwnew.eu',
      'mycleaninbox.net',
      'mypartyclip.de',
      'myphantomemail.com',
      'myspaceinc.com',
      'myspaceinc.net',
      'myspaceinc.org',
      'myspacepimpedup.com',
      'myspamless.com',
      'mytempemail.com',
      'mytrashmail.com',
      'naver.com',
      'neomailbox.com',
      'nepwk.com',
      'nervmich.net',
      'nervtmich.net',
      'netmails.com',
      'netmails.net',
      'netzidiot.de',
      'neverbox.com',
      'no-spam.ws',
      'nobulk.com',
      'noclickemail.com',
      'nogmailspam.info',
      'nomail.xl.cx',
      'nomail2me.com',
      'nomorespamemails.com',
      'nospam.ze.tc',
      'nospam4.us',
      'nospamfor.us',
      'nospamthanks.info',
      'notmailinator.com',
      'nowmymail.com',
      'nullbox.info',
      'nurfuerspam.de',
      'nus.edu.sg',
      'nwldx.com',
      'objectmail.com',
      'obobbo.com',
      'odaymail.com',
      'oneoffemail.com',
      'onewaymail.com',
      'onlatedotcom.info',
      'online.ms',
      'oopi.org',
      'opayq.com',
      'ordinaryamerican.net',
      'otherinbox.com',
      'ourklips.com',
      'outlawspam.com',
      'ovpn.to',
      'owlpic.com',
      'pancakemail.com',
      'pimpedupmyspace.com',
      'pjjkp.com',
      'plexolan.de',
      'politikerclub.de',
      'poofy.org',
      'pookmail.com',
      'privacy.net',
      'privymail.de',
      'proxymail.eu',
      'prtnx.com',
      'punkass.com',
      'putthisinyourspamdatabase.com',
      'qq.com',
      'quickinbox.com',
      'rcpt.at',
      'reallymymail.com',
      'recode.me',
      'recursor.net',
      'regbypass.com',
      'regbypass.comsafe-mail.net',
      'rejectmail.com',
      'rhyta.com',
      'rklips.com',
      'rmqkr.net',
      'rppkn.com',
      'rtrtr.com',
      's0ny.net',
      'safe-mail.net',
      'safersignup.de',
      'safetymail.info',
      'safetypost.de',
      'sandelf.de',
      'saynotospams.com',
      'selfdestructingmail.com',
      'selfdestructingmail.org',
      'sendspamhere.com',
      'sharklasers.com',
      'shieldedmail.com',
      'shiftmail.com',
      'shitmail.me',
      'shortmail.net',
      'sibmail.com',
      'sify.com',
      'skeefmail.com',
      'slaskpost.se',
      'slopsbox.com',
      'slushmail.com',
      'smaakt.naar.gravel',
      'smapfree24.com',
      'smapfree24.de',
      'smapfree24.eu',
      'smapfree24.info',
      'smapfree24.org',
      'smashmail.de',
      'smellfear.com',
      'snakemail.com',
      'sneakemail.com',
      'sofimail.com',
      'sofort-mail.de',
      'sogetthis.com',
      'soodonims.com',
      'spam.la',
      'spam.su',
      'spam4.me',
      'spamavert.com',
      'spambob.com',
      'spambob.net',
      'spambob.org',
      'spambog.com',
      'spambog.de',
      'spambog.net',
      'spambog.ru',
      'spambox.info',
      'spambox.irishspringrealty.com',
      'spambox.org',
      'spambox.us',
      'spamcannon.com',
      'spamcannon.net',
      'spamcero.com',
      'spamcon.org',
      'spamcorptastic.com',
      'spamcowboy.com',
      'spamcowboy.net',
      'spamcowboy.org',
      'spamday.com',
      'spamex.com',
      'spamfree.eu',
      'spamfree24.com',
      'spamfree24.de',
      'spamfree24.eu',
      'spamfree24.info',
      'spamfree24.net',
      'spamfree24.org',
      'spamgoes.in',
      'spamgourmet.com',
      'spamgourmet.net',
      'spamgourmet.org',
      'spamherelots.com',
      'spamhereplease.com',
      'spamhole.com',
      'spamify.com',
      'spaminator.de',
      'spamkill.info',
      'spaml.com',
      'spaml.de',
      'spammotel.com',
      'spamobox.com',
      'spamoff.de',
      'spamslicer.com',
      'spamspot.com',
      'spamthis.co.uk',
      'spamthisplease.com',
      'spamtrail.com',
      'speed.1s.fr',
      'squizzy.de',
      'supergreatmail.com',
      'supermailer.jp',
      'superrito.com',
      'suremail.info',
      'tagyourself.com',
      'teewars.org',
      'teleworm.com',
      'teleworm.us',
      'tempalias.com',
      'tempe-mail.com',
      'tempemail.biz',
      'tempemail.com',
      'tempemail.net',
      'tempinbox.co.uk',
      'tempinbox.com',
      'temp-mail.ru',
      'tempmail.it',
      'tempmail2.com',
      'tempomail.fr',
      'temporarily.de',
      'temporarioemail.com.br',
      'temporaryemail.net',
      'temporaryforwarding.com',
      'temporaryinbox.com',
      'tempymail.com',
      'thanksnospam.info',
      'thankyou2010.com',
      'thisisnotmyrealemail.com',
      'throwawayemailaddress.com',
      'throam.com',
      'tilien.com',
      'tmail.com',
      'tmailinator.com',
      'toiea.com',
      'tradermail.info',
      'trash-amil.com',
      'trash-mail.at',
      'trash-mail.com',
      'trash-mail.de',
      'trash2009.com',
      'trashemail.de',
      'trashmail.at',
      'trashmail.com',
      'trashmail.de',
      'trashmail.me',
      'trashmail.net',
      'trashmail.org',
      'trashmail.ws',
      'trashmailer.com',
      'trashymail.com',
      'trashymail.net',
      'trbvm.com',
      'trillianpro.com',
      'turual.com',
      'twinmail.de',
      'tyldd.com',
      'uggsrock.com',
      'upliftnow.com',
      'uplipht.com',
      'venompen.com',
      'veryrealemail.com',
      'vidchart.com',
      'viditag.com',
      'viewcastmedia.com',
      'viewcastmedia.net',
      'viewcastmedia.org',
      'webm4il.info',
      'wegwerfadresse.de',
      'wegwerfemail.de',
      'wegwerfmail.de',
      'wegwerfmail.net',
      'wegwerfmail.org',
      'wetrainbayarea.com',
      'wetrainbayarea.org',
      'wh4f.org',
      'whatiaas.com',
      'whatpaas.com',
      'whyspam.me',
      'willselfdestruct.com',
      'winemaven.info',
      'wronghead.com',
      'wuzup.net',
      'wuzupmail.net',
      'www.e4ward.com',
      'www.gishpuppy.com',
      'www.mailinator.com',
      'wwwnew.eu',
      'xagloo.co',
      'xagloo.com',
      'xemaps.com',
      'xents.com',
      'xmail.com',
      'xmaily.com',
      'xoxy.net',
      'yep.it',
      'yogamaven.com',
      'yopmail.com',
      'yopmail.fr',
      'yopmail.net',
      'ypmail.webarnak.fr.eu.org',
      'yuurok.com',
      'zehnminutenmail.de',
      'zippymail.info',
      'zoaxe.com',
      'zoemail.com',
      'zoemail.org',
  );

  /**
   * @var array
   */
  public static $domainsTypo = array(
      '',
      '-online.de',
      '-tonline.de',
      'acor.de',
      'aecor.de',
      'ahoo.de',
      'al.com',
      'ao.com',
      'aol.cm',
      'aol.con',
      'aol.ocm',
      'aol.om',
      'aoll.com',
      'apl.com',
      'arco.de',
      'arocr.de',
      'aror.de',
      'feenet.de',
      'freeenet.de',
      'freeent.de',
      'freeet.de',
      'freemet.de',
      'freeneet.de',
      'freent.de',
      'frenet.de',
      'gm.de',
      'gm.net',
      'gm.xde',
      'gmc.de',
      'gmx.ded',
      'gmx.dw',
      'gmxx.de',
      'gmy.de',
      'gx.de',
      'hmx.de',
      'homail.de',
      'hotmai.de',
      'hotmal.de',
      'mx.de',
      'mx.net',
      'otmail.com',
      'r-online.de',
      'rcor.de',
      'reenet.de',
      't--online.de',
      't-0nline.de',
      't-nline.de',
      't-oline.de',
      't-omline.de',
      't-onine.de',
      't-onlien.de',
      't-onliine.de',
      't-onlin.de',
      't-onlinde.de',
      't-onlinr.de',
      't-onlione.de',
      't-onlline.de',
      't-onlne.de',
      't-onlone.de',
      't.-online.de',
      't.online.de',
      'tonline.de',
      'wb.de',
      'we.de',
      'web.ded',
      'web.dw',
      'wed.de',
      'weeb.de',
      'wen.de',
      'wweb.de',
      'yaho.de',
      'yahooo.de',
      'yaoo.de',
      'yhoo.de',
      'yahhoo.de',
  );

  protected static $useDnsCheck = true;

  /**
   * check if the email is valid
   *
   * @param string     $email
   * @param bool|true  $useExampleDomainCheck
   * @param bool|true  $useTypoInDomainCheck
   * @param bool|true  $useTemporaryDomainCheck
   * @param bool|false $useDnsCheck (do not use, if you don't need it)
   *
   * @return bool
   */
  public static function isValid($email, $useExampleDomainCheck = false, $useTypoInDomainCheck = false, $useTemporaryDomainCheck = false, $useDnsCheck = false)
  {
    // make sure string length is limited to avoid DOS attacks
    if (!is_string($email) || strlen($email) >= 320) {
      return false;
    } elseif (!preg_match('/^(.*<?)(.*)@(.*)(>?)$/', $email, $parts)) {
      return false;
    } else {

      $local = $parts[2];
      $domain = $parts[3];

      // idn_to_ascii process only the domain, not the user@ part of the email
      $domain = idn_to_ascii($domain);

      $email = $parts[1] . $local . '@' . $domain . $parts[4];

      if (function_exists('filter_var')) {

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          return false;
        } else {
          $valid = true;
        }

      } else {

        $regEx = '/^(?<local>' . self::EMAIL_REGEX_LOCAL . ')@(?<domain>' . self::EMAIL_REGEX_DOMAIN . ')$/iD';

        if (!preg_match($regEx, $email)) {
          return false;
        } else {
          $valid = true;
        }

      }

      if ($useExampleDomainCheck === true && self::isExampleDomain($domain) === true) {
        return false;
      }

      if ($useTypoInDomainCheck === true && self::isTypoInDomain($domain) === true) {
        return false;
      }

      if ($useTemporaryDomainCheck === true && self::isTemporaryDomain($domain) === true) {
        return false;
      }

      if ($useDnsCheck) {
        $dnsCheck = self::isDnsError($domain);

        if ($dnsCheck !== null) {
          return (boolean) $dnsCheck;
        }
      }

    }


    return $valid;
  }

  /**
   * check if the domain is a example domain
   *
   * @param string $domain
   *
   * @return bool
   */
  public static function isExampleDomain($domain)
  {
    if (in_array($domain, self::$domainsExample, true)) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * check if the domain has a typo
   *
   * @param string $domain
   *
   * @return bool
   */
  public static function isTypoInDomain($domain)
  {
    if (in_array($domain, self::$domainsTypo, true)) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * check if the domain is a temporary domain
   *
   * @param string $domain
   *
   * @return bool
   */
  public static function isTemporaryDomain($domain)
  {
    if (in_array($domain, self::$domainsTemporary, true)) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * check if the domain has a typo
   *
   * @param string $domain
   *
   * @return bool|null will return null if we can't use the "checkdnsrr"-function
   */
  public static function isDnsError($domain)
  {
    if (function_exists('checkdnsrr')) {
      return !checkdnsrr($domain . '.', 'MX') || !checkdnsrr($domain, 'A');
    } else {
      return null;
    }
  }
}
