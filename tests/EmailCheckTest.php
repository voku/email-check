<?php
use voku\helper\EmailCheck;

/**
 * MailCheckTest
 */
class EmailCheckTest extends \PHPUnit_Framework_TestCase
{

  public function testCheckEmail()
  {
    $idnToAsciiFunctionExists = function_exists('idn_to_ascii');

    $testArrayOk = array(
        'sdsaaluzbr70l@a5k-nig8t2.com',
        'b25m_7m@amaaxtyy.com',
        'xktpwt4611mpb2r@2s2znczzc.com',
        'xo.w8w8o.q84@itpu9rkn.com',
        'f9fhx@5kle7zeruzl.com',
        '34q_l8ujm6xtw4@p10ätilyez.com',
        'us9rgyhwxtqe3@29njsdyiby.com',
        'aqp_i_t28-8t@eqdx7in.com',
        '39z7v99iyfh@ctfksxz.com',
        '792k.nf@h13nqxajg.com',
        'pukwx639mo82-2@vx-u-e.com',
        '9eeueo2auev6@zfwpb948x2.com',
        'px4o3ucyyhg@2v73d-l.com',
        'stdtr0qdzblbyc@pnvraiyg-i.com',
        'mbc@h1uz5be1qhn.com',
        'pew6tgktp@9zng2er4g.com',
        '3nn5scj2q3i@564xm086n.com',
        '3.k7sbafv4t9u@a03yös7hm.com',
        '1z2uavb3vlv@anvf8mx56x3.com',
        'fehmr8fet8y@spyi0-40.com',
        'ej24cvo@5gz0l6l2.com',
        '8imt33g_1g4y@se225ü4o7.comv',
        'vx8q9yfnsoz@adofccl5z.com',
        'rv5-ng7.3owx6@ri95zlrzp66s.com',
        'mx_kbtc.8i67_h@pu-7391.com',
        'hgzb.f-fr@td1vw3u.com',
        'ok-v1tvw@krk21r8ms8rq.com',
        'afz@u2qegprqnbf7.com',
        'fca05s6e_2@wo2to8g9xxc.com',
        'vkqwqlgfrjfna@t-online.de.com',
        "first.last@iana.org",
        "1234567890123456789012345678901234567890123456789012345678901234@iana.org",
        "first.last@3com.com",
        "first.last@123.iana.org",
        "user+mailbox@iana.org",
        "customer/department=shipping@iana.org",
        "\$A12345@iana.org",
        "!def!xyz%abc@iana.org",
        "_somename@iana.org",
        "dclo@us.ibm.com",
        "first.last@iana.org",
        "test@iana.org",
        "TEST@iana.org",
        "1234567890@iana.org",
        "test+test@iana.org",
        "test-test@iana.org",
        "t*est@iana.org",
        "+1~1+@iana.org",
        "{_test_}@iana.org",
        "test.test@iana.org",
        "test@example.iana.org",
        "test@example.example.iana.org",
        "customer/department@iana.org",
        "_Lall.Sam@iana.org",
        "~@iana.org",
        "a@bar.com",
        "a-b@bar.com",
        "+@b.com",
        "a@b.co-foo.uk",
        "valid@about.museum",
        //"foobar@192.168.0.1",
        "user%uucp!path@berkeley.edu",
        "cdburgess+!#$%&'*-/=?+_{}|~test@gmail.com",
        "test@xn--example.com",
        "foobar.66540@web.de",
    );

    $testArrayFail = array(
        'test@test.com',
        'test@example.com',
        'aluzbö70l@a5k-nig8t2.com',
        '@amaaxtyy.com',
        'xktpwt4611mpb2r@.com',
        'xo.w8w8o.q84@itpu9rkn.',
        'f9fhx@#.com',
        '@p10ätilyez.com',
        'us9rgyhwxtqe3@-.com',
        'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa@foobar.com',
        'aqp_i_t28-8t@hjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfh.hjfghfghfghgfh',
        '  @ctfksxz.com',
        '792k.nf@ .com',
        'pukwx639mo82-2@vx-u-e. ',
        ' ',
        'hjfghfghfghgfhhjfghfghfghgfhhjfghfghfghhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfhhjfghfghfghgfh@2v73d-l.com',
        'stdtr0qdzblbyc@#-i.com',
        'mbc@h1uz5be1#hn.com',
        'pew6tgktp@9zn%2er4g.com',
        '3nn5scj2q3i@564x&086n.com',
        '3.k7sbafv4t9u@a03(ös7hm.com',
        '1z2uavb3vlv@anvf)mx56x3.com',
        'fehmr8(et8y@spyi0-40.com',
        'ej24)vo@5gz0l6l2.com',
        '8imt§3g_1g4y@se§25ü4o7.comv',
        'vx8q!!!###yfnsoz@adofccl5z:a',
        'rv5-ng7.3owx6@com',
        'mx_kbtc.8i67_h@pu-7391.',
        'hgzb.f-fr@-tonline.de',
        'ok-v1tvw@aecor.de',
        'afz@al.com',
        'fca05s6e_2@-online.de',
        'vkqwqlgfrjfna@+++,com',
    );

    self::assertEquals(false, EmailCheck::isValid(''));

    $email = 'lall';
    self::assertEquals(false, EmailCheck::isValid($email), $email);

    $email = 'lall.öäü.de';
    self::assertEquals(false, EmailCheck::isValid($email), $email);

    $email = 'test@-tonline.de.de';
    self::assertEquals(false, EmailCheck::isValid($email), $email);

    $email = 'lars@moelleken.org';
    self::assertEquals(true, EmailCheck::isValid($email), $email);

    $email = 'Lars@Moelleken.ORG';
    self::assertEquals(true, EmailCheck::isValid($email), $email);

    $email = 'Lars@Mölleken.ORG';
    self::assertEquals(true, EmailCheck::isValid($email), $email);

    $email = 'Lars@MÖlleken.ORG';
    self::assertEquals(true, EmailCheck::isValid($email), $email);

    if ($idnToAsciiFunctionExists === true) {
      $email = 'Lars@Môelléken.org';
      self::assertEquals(true, EmailCheck::isValid($email), $email);
    }

    foreach ($testArrayOk as $email) {
      self::assertEquals(true, EmailCheck::isValid($email), $email);
    }

    foreach ($testArrayFail as $email) {
      self::assertEquals(false, EmailCheck::isValid($email), $email);
    }
  }

  public function testIsDnsError()
  {
    $testArrayFalse = array(
        'dsadsadasdvgffdee-foo.de',
        'ääääääöüüüüüüfoo.com',
    );

    foreach ($testArrayFalse as $domain) {
      self::assertEquals(true, EmailCheck::isDnsError($domain), $domain);
    }

    $testArrayTrue = array(
        'gmail.com',
        'aol.com',
    );

    foreach ($testArrayTrue as $domain) {
      self::assertEquals(false, EmailCheck::isDnsError($domain), $domain);
    }
  }

  public function testIsTemporaryDomain()
  {
    $testArrayFalse = array(
        'gmail.com',
        'aol.com',
    );

    foreach ($testArrayFalse as $domain) {
      self::assertEquals(false, EmailCheck::isTemporaryDomain($domain), $domain);
    }

    $testArrayTrue = array(
        '10minutemail.com',
        '20minutemail.com',
    );

    foreach ($testArrayTrue as $domain) {
      self::assertEquals(true, EmailCheck::isTemporaryDomain($domain), $domain);
    }
  }

  public function testIsTypoInDomain()
  {
    $testArrayFalse = array(
        'gmail.com',
        'aol.com',
    );

    foreach ($testArrayFalse as $domain) {
      self::assertEquals(false, EmailCheck::isTypoInDomain($domain), $domain);
    }

    $testArrayTrue = array(
        'aol.con',
        'ao.com',
    );

    foreach ($testArrayTrue as $domain) {
      self::assertEquals(true, EmailCheck::isTypoInDomain($domain), $domain);
    }
  }

  public function testIsEmailExample()
  {
    // Not valid
    self::assertFalse(EmailCheck::isValid('example.com', true, false, false, false));
    self::assertFalse(EmailCheck::isValid('example@example', true, false, false, false));
    self::assertFalse(EmailCheck::isValid('example[AT]example.com', true, false, false, false));
    self::assertFalse(EmailCheck::isValid('example@example.com', true, false, false, false));
    self::assertFalse(EmailCheck::isValid('example+label@example.com', true, false, false, false));

    // Valid
    self::assertTrue(EmailCheck::isValid('example+label@diesisteintest.de', true, false, false, false));
  }
}
