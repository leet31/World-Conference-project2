-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2016 at 05:38 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `csit537_project1`
--
CREATE DATABASE IF NOT EXISTS `csit537_project1` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `csit537_project1`;

-- --------------------------------------------------------

--
-- Table structure for table `wa_areas`
--

DROP TABLE IF EXISTS `wa_areas`;
CREATE TABLE IF NOT EXISTS `wa_areas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(20) NOT NULL,
  `DESCRIPTION` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `NAME` (`NAME`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `wa_areas`
--

INSERT INTO `wa_areas` (`ID`, `NAME`, `DESCRIPTION`) VALUES
(1, 'Cloud Computing', 'All areas of cloud computing...'),
(2, 'Internet of Things', 'A bunch of thinngs on the Internet'),
(3, 'Machine Learning', 'Machines that learn');

-- --------------------------------------------------------

--
-- Table structure for table `wa_book_details`
--

DROP TABLE IF EXISTS `wa_book_details`;
CREATE TABLE IF NOT EXISTS `wa_book_details` (
  `PRODUCT_ID` int(11) NOT NULL,
  `TITLE` varchar(256) NOT NULL,
  `ISBN` int(11) NOT NULL,
  `PUBLISHER` varchar(40) NOT NULL,
  `PUB_DATE` year(4) NOT NULL,
  `EDITION` tinyint(4) NOT NULL,
  `NUM_PAGES` int(11) NOT NULL,
  PRIMARY KEY (`PRODUCT_ID`),
  UNIQUE KEY `ISBN` (`ISBN`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wa_orders`
--

DROP TABLE IF EXISTS `wa_orders`;
CREATE TABLE IF NOT EXISTS `wa_orders` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CUSTOMER_ID` int(11) NOT NULL,
  `ORDER_DATE` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `CUSTOMER_ID` (`CUSTOMER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wa_order_details`
--

DROP TABLE IF EXISTS `wa_order_details`;
CREATE TABLE IF NOT EXISTS `wa_order_details` (
  `ORDER_ID` int(11) NOT NULL,
  `PRODUCT_ID` int(11) NOT NULL,
  `QUANTITY` int(11) NOT NULL,
  PRIMARY KEY (`ORDER_ID`,`PRODUCT_ID`),
  KEY `ORDER_DETAILS_PRODUCT_ID` (`PRODUCT_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wa_papers`
--

DROP TABLE IF EXISTS `wa_papers`;
CREATE TABLE IF NOT EXISTS `wa_papers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `AUTHOR_ID` int(11) NOT NULL COMMENT 'User ID of paper''s author',
  `REVIEWER_ID` int(11) DEFAULT NULL COMMENT 'User ID of paper''s reviewer',
  `SUBAREA_ID` int(11) NOT NULL COMMENT 'ID from wa_subareas',
  `TITLE` varchar(50) NOT NULL,
  `MIME` varchar(255) NOT NULL COMMENT 'mime type',
  `DOCUMENT` longblob COMMENT 'Attach PDF/Word Doc',
  PRIMARY KEY (`ID`),
  KEY `AUTHOR_ID` (`AUTHOR_ID`,`REVIEWER_ID`,`SUBAREA_ID`),
  KEY `REVIEWER_ID` (`REVIEWER_ID`),
  KEY `AUTHOR_ID_2` (`AUTHOR_ID`),
  KEY `SUBAREA_ID` (`SUBAREA_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `wa_papers`
--

INSERT INTO `wa_papers` (`ID`, `AUTHOR_ID`, `REVIEWER_ID`, `SUBAREA_ID`, `TITLE`, `MIME`, `DOCUMENT`) VALUES
(2, 1, 20, 3, 'My Document', '', 0x504b03041400060008000000210009248782810100008e050000130008025b436f6e74656e745f54797065735d2e786d6c20a2040228a000020000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000b4944d4f83401086ef26fe07b25703db7a30c694f6a0f5a84dacf1bc2e43d9c87e6467fbf5ef1d4a4baaa1a55abd90c032effbcc0b3383d14a97d1023c2a6b52d64f7a2c02236da6cc2c65afd3c7f896451884c944690da46c0dc846c3cb8bc174ed0023aa3698b2220477c739ca02b4c0c43a3074925baf45a05b3fe34ec80f31037eddebdd70694d0013e25069b0e1e00172312f43345ed1e39ac443892cbaaf5facbc52269c2b95148148f9c264df5ce2ad4342959b77b0500eaf0883f15687eae4b0c1b6ee99a2f12a8368227c78129a30f8d2fa8c6756ce35f5901c9769e1b479ae2434f5959af356022265aecba439d142991dff410e0ceb12f0ef296add13eddf5428c6790e923e76771e1ae3aae9a4b6d8abed76831028a4534cbefe827157e8b855ee4458c2fbcbbf51ec897782e4341a53f15ec20989ff308c46ba1322d0bc03df5cfb67736c648e59d2644cbc7548fbc3ffa2eddd82a8aa631a39073e28685644db88358eb47bceee0faaed9641d6e2cd37db74f8090000ffff0300504b0304140006000800000021001e911ab7f30000004e0200000b0008025f72656c732f2e72656c7320a2040228a0000200000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000008c92db4a03410c86ef05df61c87d37db0a22d2d9de48a17722eb038499ec01770ecca4dabebda320ba50db5ee6f4e7cb4fd69b839bd43ba73c06af6159d5a0d89b6047df6b786db78b075059c85b9a82670d47ceb0696e6fd62f3c9194a13c8c31aba2e2b38641243e226633b0a35c85c8be54ba901c4909538f91cc1bf58cabbabec7f457039a99a6da590d6967ef40b5c758365fd60e5d371a7e0a66efd8cb8915c807616fd92e622a6c49c6728d6a29f52c1a6c30cf259d9162ac0a36e069a2d5f544ff5f8b8e852c09a10989cff37c759c035a5e0f74d9a279c7af3b1f21592c167d7bfb4383b32f683e010000ffff0300504b0304140006000800000021007c3b973922010000b90300001c000801776f72642f5f72656c732f646f63756d656e742e786d6c2e72656c7320a2040128a0000100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000ac934d4f84301086ef26fe07d2bb14565d8dd9b21735d9abaef1dc2d5368849674c60ffebd15b30acaa2072e4d669abecfd349bb5abfd555f4021e8db382a571c222b0cae5c616823d6c6f4f2e5984246d2e2b6741b01690adb3e3a3d51d5492c2212c4d835148b1285849d45c718eaa845a62ec1ab061473b5f4b0aa52f7823d5932c802f9264c97d3f836583cc68930be637f9298bb66d13c87f673bad8d826ba79e6bb03482e00844e1661832a52f8004db77e2e0c9f8b8c2e280426d9477e834c5cad5fc93fe41bd185e8c23b515e0a3a1f2466b50d4c7ffdc9af2480f788c8cf91fa3e8c8bd4174f5147e39279ec20b816f7a57f26e4da71ccee774d0ced256eeaa9ec7576b4ae26c4e8957d8ddff7a95bde65e840f3e5cf60e0000ffff0300504b03041400060008000000210060033ceb4f0200005606000011000000776f72642f646f63756d656e742e786d6ca455c96edb3010bd17e83f08bcdb921c6781e005489c1a391408ea143d1634454984450e415256d3afef509bdd3830b25c249233f316521ccd967f6419ecb9b102d49cc4e388045c314885cae7e4e7d3b7d10d09aca32aa525283e27cfdc92e5e2eb97599da4c02ac9950b1042d9a4d66c4e0ae774128696155c523b968219b090b9310319429609c6c31a4c1a4ea2386a46da00e3d622df1d557b6a4907274fd14073855c1918499d1d83c94349cdaed22344d7d489ad28857b46ece8aa878139a98c4a3a41a341902f495a41ddabaf30272e5ee16d2b57dd0e348ca1e1256a00650ba10f363e8a86168b5ed2fe9c89bd2cfbbc5ac7d313bec1f25bce6065688d4771003c817b6533d2b64896ed3ef8f33d9cea4bc4383a67a63b110f3168788b84ff397b25920a35c07c6c6b8e37176fc467beefb5814a0f72b4f81cda83da0d58fe62be435974d5dcbc636bf65d002757775350cd492059f2902b30745ba2a23a9e06fe8b240b6c165b489ffd5b077582cd26fd31275134bd8da3eb7bd22fad7846abd2f9c8dd65bcba682b8d2f738b5f05373c103670050f5425b7dc0496efb95ace421ff74f4cc5a73ee1e9d0cef36c0176be9d6c1c350e53458a42bc364525baf9bd865bca76246cddb4b9f72a1d3231d0935bcedca3e9e95ef8d1f9e62f866aecb693c9b46128707c7983e3065ce7dfa92f76a0717ddaa6189117b833fd740bce813ccc4b9e1d450b4e538e7dec7ad2c06700ee689a57ae9976740c4a8b6c565386367d49a302bbfbda086faf148a3f0ac750e5c55513459fadc5c6727bb4b8d6ff1016ff000000ffff0300504b03041400060008000000210030dd4329a8060000a41b000015000000776f72642f7468656d652f7468656d65312e786d6cec594f6fdb3614bf0fd87720746f6327761a07758ad8b19b2d4d1bc46e871e698996d850a240d2497d1bdae38001c3ba618715d86d87615b8116d8a5fb34d93a6c1dd0afb0475292c5585e9236d88aad3e2412f9e3fbff1e1fa9abd7eec70c1d1221294fda5efd72cd4324f1794093b0eddd1ef62fad79482a9c0498f184b4bd2991deb58df7dfbb8ad755446282607d22d771db8b944ad79796a40fc3585ee62949606ecc458c15bc8a702910f808e8c66c69b9565b5d8a314d3c94e018c8de1a8fa94fd05093f43672e23d06af89927ac06762a049136785c10607758d9053d965021d62d6f6804fc08f86e4bef210c352c144dbab999fb7b4717509af678b985ab0b6b4ae6f7ed9ba6c4170b06c788a705430adf71bad2b5b057d03606a1ed7ebf5babd7a41cf00b0ef83a6569632cd467faddec9699640f6719e76b7d6ac355c7c89feca9cccad4ea7d36c65b258a206641f1b73f8b5da6a6373d9c11b90c537e7f08dce66b7bbeae00dc8e257e7f0fd2badd5868b37a088d1e4600ead1ddaef67d40bc898b3ed4af81ac0d76a197c86826828a24bb318f3442d8ab518dfe3a20f000d6458d104a9694ac6d88728eee2782428d60cf03ac1a5193be4cbb921cd0b495fd054b5bd0f530c1931a3f7eaf9f7af9e3f45c70f9e1d3ff8e9f8e1c3e3073f5a42ceaa6d9c84e5552fbffdeccfc71fa33f9e7ef3f2d117d57859c6fffac327bffcfc793510d26726ce8b2f9ffcf6ecc98baf3efdfdbb4715f04d814765f890c644a29be408edf3181433567125272371be15c308d3f28acd249438c19a4b05fd9e8a1cf4cd296699771c393ac4b5e01d01e5a30a787d72cf1178108989a2159c77a2d801ee72ce3a5c545a6147f32a99793849c26ae66252c6ed637c58c5bb8b13c7bfbd490a75330f4b47f16e441c31f7184e140e494214d273fc80900aedee52ead87597fa824b3e56e82e451d4c2b4d32a423279a668bb6690c7e9956e90cfe766cb37b077538abd27a8b1cba48c80acc2a841f12e698f13a9e281c57911ce298950d7e03aba84ac8c154f8655c4f2af074481847bd804859b5e696007d4b4edfc150b12addbecba6b18b148a1e54d1bc81392f23b7f84137c2715a851dd0242a633f900710a218ed715505dfe56e86e877f0034e16bafb0e258ebb4faf06b769e888340b103d331115bebc4eb813bf83291b63624a0d1475a756c734f9bbc2cd28546ecbe1e20a3794ca175f3fae90fb6d2dd99bb07b55e5ccf68942bd0877b23c77b908e8db5f9db7f024d9239010f35bd4bbe2fcae387bfff9e2bc289f2fbe24cfaa301468dd8bd846dbb4ddf1c2ae7b4c191ba8292337a469bc25ec3d411f06f53a73e224c5292c8de0516732307070a1c0660d125c7d44553488700a4d7bddd3444299910e254ab984c3a219aea4adf1d0f82b7bd46cea4388ad1c12ab5d1ed8e1153d9c9f350a3246aad01c6873462b9ac05999ad5cc988826eafc3acae853a33b7ba11cd1445875ba1b236b1399483c90bd560b0b0263435085a21b0f22a9cf9356b38ec6046026d77eba3dc2dc60b17e92219e180643ed27acffba86e9c94c7ca9c225a0f1b0cfae0788ad54adc5a9aec1b703b8b93caec1a0bd8e5de7b132fe5113cf312503b998e2c2927274bd051db6b35979b1ef271daf6c6704e86c73805af4bdd476216c26593af840dfb5393d964f9cc9bad5c313709ea70f561ed3ea7b053075221d51696910d0d339585004b34272bff7213cc7a510a5454a3b349b1b206c1f0af490176745d4bc663e2abb2b34b23da76f6352ba57ca2881844c1111ab189d8c7e07e1daaa04f40255c77988aa05fe06e4e5bdb4cb9c5394bbaf28d98c1d971ccd20867e556a7689ec9166e0a522183792b8907ba55ca6e943bbf2a26e52f48957218ffcf54d1fb09dc3eac04da033e5c0d0b8c74a6b43d2e54c4a10aa511f5fb021a07533b205ae07e17a621a8e082dafc17e450ffb739676998b48643a4daa7211214f623150942f6a02c99e83b85583ddbbb2c4996113211551257a656ec1139246ca86be0aadedb3d1441a89b6a929501833b197fee7b9641a3503739e57c732a59b1f7da1cf8a73b1f9bcca0945b874d4393dbbf10b1680f66bbaa5d6f96e77b6f59113d316bb31a795600b3d256d0cad2fe354538e7566b2bd69cc6cbcd5c38f0e2bcc63058344429dc2121fd07f63f2a7c66bf76e80d75c8f7a1b622f878a18941d840545fb28d07d205d20e8ea071b283369834296bdaac75d256cb37eb0bee740bbe278cad253b8bbfcf69eca23973d939b97891c6ce2cecd8da8e2d343578f6648ac2d0383fc818c798cf64e52f597c740f1cbd05df0c264c49134cf09d4a60e8a107260f20f92d47b374e32f000000ffff0300504b03041400060008000000210011903b2885030000cb08000011000000776f72642f73657474696e67732e786d6cb456db6edb38107d5f60ff41d0f33a927c490b214ed12475b745bc2d56e90750e25826c21b48ca8afbf53b14c5a846bc41b1c53e79349733f7a1afde3d099e1cc058a6e43a2d2ef23401d928ca64bb4ebf3d6c666fd3c43a2229e14ac23a3d824ddf5dfffedb555f5a700ed56c8210d296a259a77be7749965b6d98320f642699028dc292388c34fd3668298c74ecf1a253471ac669cb96336cff3cb748451ebb433b21c216682354659b573dea454bb1d6b60fc8916e667fc06cb3bd57402a41b3c660638c6a0a4dd336d239af8af6898e23e821c5e4be22078d4eb8bfc35cd31dd5e19fa6cf133e179036d5403d66283040fe90ac2e4334cb17c01f45cea0b2c75167c671e0acd8b7ca0a6c82d7f617fa6dba18bf7ac36c48436e300f82844537e6aa532a4e638547db14caf71a2be2b2592bed4601a6c128e6391a7991760326a5739e200c55603e7c37c361c0882f5656b88c0c95aa78133d850d8918ebb0752574e69543a108cf9cd7c846cf6c490c681a9346910ed564967148f7a54fda5dc2d4ea9c1228620c2ccfa70025585f9470b49046611b8e34c6f15051f5967d88b42fd6ba1bdc11025d663c8e1bc2385fb6a18054c8d43e58e1c36187cc5bec37b493f77d631dc9261b27f2182d70200e93d7fc1ed7e386ad800711d96e97f72367462c399de326394f92429cec6af3acb62137d3bf1f8511b89bf9572b10d797ebb2aee166333bcda2459de14f99b0fa14aa792d5329f17ab73929b62b1c8df9f934c7e30b2311e51fa93f2d55c5f05ca37391161406e89a80d23c9d61f1d1c1551d6e6f186c928af018f2efc28a9ba3a0a67b320b08270bec12d88826135444999d577b01b60f9969876c21d35cc592e6edce7672cbfc1603e1ad5e9e0ad374487e64577c57239e231e9ee99887cdbd555b49278387e1075927e39180f984de5e94b87efcdb004f744b6b1472067df2aaf8abde6a6f26f126c89d6b8eca852b7c53ae5acddbbc20faec32f8a6fd3f051b7f351361f64f8e565c307697c66a83d125e2190a83512136f11798b89879737e82d27de2af25613ef32f2f06deccb3d6e9ac1b3f788e724929ebf539cab1ee89f91b94e5fb04211ec9e68c0befaab88e3aeca81319e499b1c4a78c29b0b94397cf235a3823ce109cee797de7cd4e6e4a83a77a2eb655e599f70134a1c41f3a15527c6d83abce1a7b1f4258586e1385647514f47f82204ce99751568bcd74e194c7938917f0cc8d3bf90eb7f000000ffff0300504b03041400060008000000210017a0164e02010000ac01000014000000776f72642f77656253657474696e67732e786d6c8cd0c14a03311006e0bbe03b2cb9b7d99522b274b72052f12282fa006976761bcc64c24c6aac4f6fdaaa205e7acb24998f997fb9fa405fbd038ba3d0a9665eab0a82a5c185a953af2febd98daa249930184f013ab50751abfef26299db0c9b6748a9fc94aa28415ab49ddaa6145badc56e018dcc2942288f23319a544a9e341a7edbc599258c26b98df32eedf5555d5fab6f86cf51681c9d853bb23b84908efd9ac11791826c5d941f2d9fa365e22132591029fba03f79685cf8659ac53f089d65121ad3bc2ca34f13e90355da9bfa7842af2ab4edc31488cdc6970473b3507d898f6272e83e614d7ccb9405581fae8df7949f1eef4ba1ff64dc7f010000ffff0300504b03041400060008000000210051e2e3bfbc0700005e3d00001a000000776f72642f7374796c657357697468456666656374732e786d6cb49bdf53db3810c7df6fe6fe078fdf21245068334d3b14da2b336d8f3630f7acd80ad1605b3eff20707ffdad245b31766cefc6ee538963ed6757bbfaaea0d2fb8fcf61e03cf12415325ab8d3e313d7e191277d113d2cdcfbbb2f476f5d27cd58e4b340467ce1bef0d4fdf8e1cf3fde6fe769f612f0d40103513adfc6dec2dd64593c9f4c526fc343961e87c24b642ad7d9b127c3895caf85c7275b99f893d9c9f444ff1427d2e3690ab42b163db1d42dcc854d6b32e611b0d6320959961ecbe46112b2e4318f8fc07acc32b11281c85ec0f6c97969462edc3c89e6854347d62135646e1c2afe2947248d28f670cdc86be9e5218f324d9c243c001f64946e44bc0be3506b10e2a674e9a92b88a73028dfdbc6d3b306cf868cc9c175c2b6908a9dc186b93d93e19b416160e641e57797d5bac5e949573045469409eb03c685d7ccd2939089c89a396c6aaa930beb61487dff95c83cb6eec46298b59be8d1da52cb92e0d9c9b95e79d5d0529281c6d25d6e58cc5d27f4e6370f914cd82a008fb6d3334755a4fb01a4c297de355fb33cc852f531b94d8a8fc527fdcf171965a9b39db3d413e20e2404ac84020c7ebd8c52e1c2379ca5d9652ad8de2f37eaadbddf786956b1f649f8c29d2862fa1fd87c62c1c29dcdca2757ca8357cf02163d94cf787474bfac7ab270eda315d85db82c395a5e2a63131d66f96f25dcf855f0f049bb12330f561e70d83ae32042b33350e2ed3c102abb676fed875fb99a5c9667b280680300ab9a858fb519076d02a55a1ac5866ff9fa9bf41eb9bfcce08b85abcdc3c3fb9bdb44c8046474e1be7ba71c80874b1e8aafc2f7b96a10c5b3fb68237cfecf8647f729f777cf7f7ed1f25c58f4641e6510cbf985ae8220f53f3f7b3c563209a623a632fc430d000d83745438daa15cecbc310f6a54fdf0df12393539dc4bd970a65a9aa3fdef04e9a8f3c1a0998aa81a80b64bf2f574b889b3e126de0c3701ed78e85c5c0c37011b99a15e98daa854253ea999f44cf1556be2f45d47c9aa118d2aea1dd1289ade118d1ae91dd12889de118d0ae81dd14878ef88467e7b4734d2d939c2635ab8ea5574aa6703b5b0ef4416409fec51bae940a92b5a8d73cb12f690b078e3a8c65a77bb4b2c97f92ac3b9aae5f470b15c668954dbcd9e1981eeac96eec19afc398c372c15b02bef030d9cfa3bb5f571fe4a046c5f7b506f4cf13562d21b93bd2dec36601edfc8c0e78973c79f4d4609e37f4867697619bdce0d4ceb37f1b0c91cd815aa96db0b3b6f99f4f69930f6bf8954cf4167373f6f09a5cf382a87e72d75d96efc3bf7451e965383d88d9c1b3d27a4b986d02e764fd1994a517375f546a1128009c1b40b7a08da3ec27fd35ce8f6558e31fe9b5674a07d84ffa6711d685fd747777ec94a730d7f567150cbeb82bc76af642093751e946ba0571e2ec82bd82270219017b1b58f12890bf20a7e259fcea5e7c16f6e983a25e762a7a3040a391d86a2171b3e1672526ab2372544444e508d3523b086692d014416dd5ffc49a83f02539b815669bbd7ec5dcea72d33002d08b587fe99cbac7f0f3d6bd13c2ce526823f97a4dcc1d14e5b561e9656d493e977841c0f6b7c04d0b00e48000d6b8504504b7db4ef796c4fc443863747028b2ccbb68be9b2432bf30559992d88d60246ea9b88fd57cbea6daf8566df4450c8096af64d04859c9d5a2fb37d13c11aad6f22582d5da33d47554da50445ee9b5590dd0920221a47bc11a071c41b011a47bc11a0e1e2dd0f194fbc112cb236584dad8a3702a45fa1fcaa6f4155f14680c8da60d4aef89b51d9f7b495ee5f6e47106f04859ca0a6782328e4ecb4893782a55fa154428d65a50ec11a47bc11a071c41b011a47bc11a071c41b011a47bc11a0e1e2dd0f194fbc112cb236584dad8a37024496070baa8a3702a45fa168c35ef1d6abfeb78b3782424e5053bc111472766a826a37a9081639413596156f044bbf42298682a58b9b12d438e28d88681cf14680c6116f04681cf14680868b773f643cf146b0c8da6035b52ade0810591e2ca82ade0810591bf68ab75e8cbf5dbc111472829ae28da090b3531354ab73081639413596156f044bd7cb60f14680f42b878228118d23de8888c6116f04681cf14680868b773f643cf146b0c8da6035b52ade0810591e2ca82ade0810591bf68ab75e23bf5dbc111472829ae28da090b35313542bde081639413596953a046b1cf1468074610e166f0448bf720048af224a9ac6116f4444e3883702345cbcfb21e389378245d606aba955f14680c8f2604155f14680c8daa0ced9c27951f4f1d4694b1160cf1994a71ad0c0594b92b0c022c05f7ccd13b855c8fb4f870c04961112882de5810df193948f0eee60f7694b81a051621508a98f74bfe8533a958b08a7171d3709eefebe72be9a0b308d71baa45e9fbc81db43d5eb42fa7a92ba38047e662f315cd989cb93e5ca1a5c1052f7ba8a2b40fa4ee80d5c082aaef5a8c1ea9e0fbca82f55158ff5ffdb1654f819887a6013e56d80e5c18da80e5471e0dd9e41d2c7ddebe09653f1da91dd958cd2cde274fc6e0f65de7b7546b3d3ef4c9d04eff0599f14ef9c2347bf62b2da74102e676997fa3c8494ad0273c50c7eb8897c88705bdcce32c9f49f993105df5ff120f8cef485b44cc6edaf067c9d996fa727ba03d64cad6496c9b07d7ca20f886b4ff6198072a83a633eaa20daeb24cac3154f8ae3e6ad25a93a87be89f6ba24cd59d79652c0cef4ceb7f2a7f4c3ff000000ffff0300504b030414000600080000002100eba4037b450100007702000011000801646f6350726f70732f636f72652e786d6c20a2040128a00001000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000009c92514bc3301485df05ff43c97b9b661b324a9b81ca5e74203871f81692bb2dd8a42189ebf6ef4ddaad76e8938f37e7e4bbe7dea45c1c559d1cc03ad9e80a912c470968de08a977157a5b2fd3394a9c675ab0bad150a11338b4a0b7372537056f2cbcd8c680f5125c1248da15dc5468efbd2930767c0f8ab92c387410b78d55cc87d2eeb061fc93ed004ff2fc0e2bf04c30cf7004a66620a23352f00169be6cdd0104c7508302ed1d2619c13f5e0f56b93f2f74cac8a9a43f9930d339ee982d782f0eeea39383b16ddbac9d7631427e8237abe7d76ed454eab82b0e88968217dc02f38da54f7090bac4a393b8bd9a39bf0a8bde4a10f7a78be9b710bd3610e20b5152e27119ba7443f5ad40242166d10f7551dea70f8feb25a2939ccc5242d29cacc9bc98cc8a3cff8899aeeec7d8fd813a27fb37f102a05de2ebaf42bf010000ffff0300504b030414000600080000002100af5cb6123c0700006d3a00000f000000776f72642f7374796c65732e786d6cb49bdf739b3810c7df6fe6fe0786f7d4b19d266da66e274ddb6b66da5e5a2773cf18645b53401cc84d727ffdad565821606037d0a7981fda8f56bbfaaeec486fdedd27b1f74be48554e9c29fbe38f63d91862a92e966e1dfde7c3a7ae57b850ed22888552a16fe8328fc776ffffce3cddd79a11f62517860202dce9370e16fb5cece279322dc8a24285ea84ca4f070adf224d070996f264990ffdc6547a14ab240cb958ca57e98cc8e8f4ffdd24c4eb1a2d66b198a0f2adc2522d5d87e928b182caab4d8caacd85bbba358bb537994e52a1445014e27b1b59704327566a6270d43890c7355a8b57e01ce4c6c8f26c614349f1ee3a724f6bd243cbfdaa42a0f56310cdeddf4c47f0b2317a9f0835807bb5817e632bfcecbcbf20aff7c52a92ebcbbf3a008a5bc8121050389045b9f2fd242faf0440485be286470f0e1d6bc75f04958e88ab5f73292fec4108bffc0e6af205ef8b3d9fecea5e9c1937b71906ef6f7447a74bbacf664e1bb5b2bb0bbf083fc6879618c4dd0cdfddf8abbd913e7e10abb920521040338c15a0b488ad90924e6dd792c4d0e9ebc72173f76665c839d5625040d00ac6a162e6b230eb90299b3b4090c4fc5fa8b0a7f8a68a9e1c1c247f370f3f6ea3a972a87245df8af5f9b0ec0cda548e4671945c2cc97f2de6dba9591f8672bd2db42448ff7bf7fc2e42f2d866a976af0e5f40cb3202ea28ff7a1c84cda82e9343011fe661a40e240382a1cecd04e3ef6c6dea851f1e6bf7be4d4c6f020652b0233c33dec7f2708bdde0d06cd8c475507d02eabaff3e1264e869b7839dc0488ddd0b1381b6e02747d682f6c6e54b2921e54ad429b7cd59c98bfee4859d3a29145bd2d1a49d3dba29123bd2d1a29d1dba29101bd2d1a01ef6dd1886f6f8b46383b5b84010a573d8be6381aa4897d23752c4cfb4e019a0e94bab2d478d7411e6cf220db7aa6b0d6bbdd2596cbdd4ad3ba8a72fa7cb15cea5ca59bde1181ea6ca6eeb335f963926d8342c22aa967e8670387fec6ac7abcbf7219f5a25edae46bf8840b938325ec3a0e42b155712472ef46dcdb8832da7f53ded2ae327a3b3730ac5fe466abbde5164b6e2fecb465d0db47c2daff220b1c83cec974dae24a9f71520c4f5bf2b2ddf85711c95db21f1ac26ae4d4ea3923cc350476b17b884e4c889ab3abd70b13008a0bb65cf05d40fb84fedbe2c2b76f624ce9bf2d45cfb44fe8bf2d5ccfb48ff9d11d5fb6d27c802fad1e697a9db1e7eea58a55bedec5fb39d02b0f67ec19ec103417d893d8d92789c4197b063f914fef220ce19b1b254fd9b178d45106851d0e4bc1c946f7851d949aec4d191eb1035463cd18ac615acb00b145f787f825cd6f62dc62802aedd69abdd379de32025082486be8ef3ba5fbd7d0b316cda352ae52f8b9a4101e8d366f9979545a994fb6de31623cacf03140c32a200334ac1432402df9d1bee67135910e195e1c192cb62cbb2a86694756e633b6323b10af048c543709ebaf96d9db9e0bcdba49a0b003d4ac9b040a3b3ab55ae6ea2681355add24b05aaa467b8caa9aca718a5d37ab20b7122078348e781340e3883701348e781340c3c5bb1f329e7813586c6d709a5a156f02085fe17cd577a0aa7813406c6db06a57fe66b4af7b68a5fbcbed08e24da0b003d4146f02851d9d36f126b0f0154e26d4584eea08ac71c49b001a47bc09a071c49b001a47bc09a071c49b001a2edefd90f1c49bc0626b83d3d4aa7813406c7970a0aa781340f80a471b0e8a37cefadf2ede040a3b404df12650d8d1a909aa5ba41258ec00d5584ebc092c7c85930c250b939be3d438e24df0681cf12680c6116f02681cf12680868b773f643cf126b0d8dae034b52ade04105b1e1ca82ade04105b1b0e8a374ec6df2ede040a3b404df12650d8d1a909aad339028b1da01acb89378185f93258bc09207ce5b9208e47e38837c1a371c49b001a47bc09a0e1e2dd0f194fbc092cb636384dad8a3701c4960707aa8a3701c4d68683e28d73e4b78b3781c20e5053bc091476746a82eac49bc06207a8c6725247608d23de041026e660f12680f0956780701671c2348e78133c1a47bc09a0e1e2dd0f194fbc092cb636384dad8a3701c4960707aa8a3701c4d606b3cf16f68b92b7a74e5b9280bacf60bfab810c9cb504890a2c1dfc21d622874356a27f77c840e0de4306b1253da82ebe57eaa747dbd83d6f4910324aae62a9704bf703eed2a91c44989f759c24b8f9fbd2fb6c0fc034da614a3ddd7903a787aac785f07892393804fdd40f191cd9c9f63bcb8d35382064ce75954780f088dc151c082a8ff598c6e69c0fbc8887aacadbf87fdb920a9f81880d9ba8700bac104e4475a0ca0def6e0f126e77af835b76c563471e8f64ecbb59ee8e7f5c43d9f79eecd1ececb7363bc13bfa8c3bc53bc7c8c3576c549b1d84c359d8a5be1e42c856b13d62061faed2083c844382f85f331bcce83eb0a6e0f9a588e3af011e48d32a6b7f35166b6d9f4e8fb102d64cad94d62a696f9fe30671ecc92103900ed5ced84be3447b9ea4bb64257238e1d531e6df94a91c7812ed694adabdae2da9401de9c7beed3f156fff070000ffff0300504b03041400060008000000210016e9414ac3010000a204000012000000776f72642f666f6e745461626c652e786d6ca492dd4ee3301085ef57da77887c4feda481858814a1ee56e2662f56f000aeeb3416fe893c6eb37d7b26761a2e2a440b8e1425673c47339fcefdc37fa3b3bdf4a09cad493e63249356b88db2db9abc3cafae6e490681db0dd7ceca9a1c249087c5cf1ff77dd5381b20c37e0b9511356943e82a4a41b4d27098b94e5a2c36ce1b1ef0d76fa9e1fe75d75d09673a1ed45a69150eb460ec868c36fe1c17d7344ac8df4eec8cb421f6532f353a3a0badeae0e8d69fe3d63bbfe9bc13120077363af919aeec64939727464609efc0356186cbd034111dacb03d67f1cb689219513d6dadf37cad915d9f97643182cbfaca7283e2926bb5f62a163a6e1dc81c6b7bae6bc20ab662d7f81e9e92cd8737a1838368b90719a68b2cc90d374a1f8e2af40a20153a15447bd4f7dcab61a05402b5c5c20ed6ac267f189e62b52249c96b52a2f0b89c9402874a271fefcc2705938383459f7825bf8b3ea8a0cfd815e7a4293a27249e959190fd957df6cf196e3f2052b01b24718d3c0632f38b88f8e81b095e40a4789cf6c74d96b8caafdbf2b8ff3b91bbcf89249ff3892cb9c168f00f480c04128981c865d9f81a89d36cb07262f34e22260113f59d6c8c2181c51b000000ffff0300504b0304140006000800000021000f24519281010000d602000010000801646f6350726f70732f6170702e786d6c20a2040128a00001000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000009c524d6fdc2010bd57ca7fb07cdfc5bb8ada2a9a25aa368a72e8c74aeb24e7118c6d140c08489afdf71de2ace3aab7729a790f1e6f1ec0f5eb68ab178ac978b7ab37eba6aec829af8deb77f57d7bbbfa5a5729a3d368bda35d7da2545fcb8b4f70883e50cc8652c5122eedea21e770254452038d98d64c3b663a1f47ccdcc65ef8ae338a6ebc7a1ec965b16d9acf825e33394d7a1566c17a52bc7ac9ff2baabd2afed2437b0a6c58424b63b09849fe2c76ec5afb3c829851687d46db9a9164c3f0dcc0017b4a7203622ae0d1479de42588a980fd801155e6fce496d1450bdf42b04661e660e50fa3a24fbecbd5afb708aa721cc4720b702c4752cfd1e45331b16ce1bb71938da9605b11fb886178f7367770546869cfb3cb0e6d22101f00ecfd18d09de41dfdb694f3ea80ea098b8f3351ee794af7a1f53725ab7785bfc1c5c88f260fc7808aad6dbf2c875f1070e48448f33467b90f00eef875a22d777270ae277ddef32f51e27c98bea9dc5cae1b5e6ff99d317ea1f9ffc83f000000ffff0300504b01022d001400060008000000210009248782810100008e0500001300000000000000000000000000000000005b436f6e74656e745f54797065735d2e786d6c504b01022d00140006000800000021001e911ab7f30000004e0200000b00000000000000000000000000ba0300005f72656c732f2e72656c73504b01022d00140006000800000021007c3b973922010000b90300001c00000000000000000000000000de060000776f72642f5f72656c732f646f63756d656e742e786d6c2e72656c73504b01022d001400060008000000210060033ceb4f02000056060000110000000000000000000000000042090000776f72642f646f63756d656e742e786d6c504b01022d001400060008000000210030dd4329a8060000a41b00001500000000000000000000000000c00b0000776f72642f7468656d652f7468656d65312e786d6c504b01022d001400060008000000210011903b2885030000cb08000011000000000000000000000000009b120000776f72642f73657474696e67732e786d6c504b01022d001400060008000000210017a0164e02010000ac01000014000000000000000000000000004f160000776f72642f77656253657474696e67732e786d6c504b01022d001400060008000000210051e2e3bfbc0700005e3d00001a0000000000000000000000000083170000776f72642f7374796c657357697468456666656374732e786d6c504b01022d0014000600080000002100eba4037b45010000770200001100000000000000000000000000771f0000646f6350726f70732f636f72652e786d6c504b01022d0014000600080000002100af5cb6123c0700006d3a00000f00000000000000000000000000f3210000776f72642f7374796c65732e786d6c504b01022d001400060008000000210016e9414ac3010000a204000012000000000000000000000000005c290000776f72642f666f6e745461626c652e786d6c504b01022d00140006000800000021000f24519281010000d602000010000000000000000000000000004f2b0000646f6350726f70732f6170702e786d6c504b0506000000000c000c0009030000062e00000000),
(3, 44, NULL, 5, '', '', ''),
(4, 46, NULL, 1, '', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wa_products`
--

DROP TABLE IF EXISTS `wa_products`;
CREATE TABLE IF NOT EXISTS `wa_products` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CATEGORY` int(11) NOT NULL,
  `NAME` varchar(20) NOT NULL,
  `DESCRIPTION` varchar(256) NOT NULL,
  `PRICE` float NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wa_product_categories`
--

DROP TABLE IF EXISTS `wa_product_categories`;
CREATE TABLE IF NOT EXISTS `wa_product_categories` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CATEGORY_NAME` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `CATEGORY_NAME` (`CATEGORY_NAME`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `wa_product_categories`
--

INSERT INTO `wa_product_categories` (`ID`, `CATEGORY_NAME`) VALUES
(9, 'Category 5'),
(12, 'Category 7'),
(13, 'category 8'),
(1, 'Test Category'),
(2, 'Test Category 3'),
(3, 'Test Category 4');

--
-- Triggers `wa_product_categories`
--
DROP TRIGGER IF EXISTS `PREV_BLANK_CAT_INSERT`;
DELIMITER //
CREATE TRIGGER `PREV_BLANK_CAT_INSERT` BEFORE INSERT ON `wa_product_categories`
 FOR EACH ROW BEGIN
	IF NEW.CATEGORY_NAME = '' THEN
		SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Blank values are not allowed';
    END IF;
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `PREV_BLANK_CAT_UPDATE`;
DELIMITER //
CREATE TRIGGER `PREV_BLANK_CAT_UPDATE` BEFORE UPDATE ON `wa_product_categories`
 FOR EACH ROW BEGIN
	IF NEW.CATEGORY_NAME = '' THEN
		SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Blank values are not allowed';
    END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `wa_subareas`
--

DROP TABLE IF EXISTS `wa_subareas`;
CREATE TABLE IF NOT EXISTS `wa_subareas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `PARENT_ID` int(11) NOT NULL,
  `NAME` varchar(20) NOT NULL,
  `DESCRIPTION` varchar(256) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `SUBAREA_NAME_PARENT` (`PARENT_ID`,`NAME`) COMMENT 'Prevent duplicate subareas',
  KEY `PARENT_ID` (`PARENT_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `wa_subareas`
--

INSERT INTO `wa_subareas` (`ID`, `PARENT_ID`, `NAME`, `DESCRIPTION`) VALUES
(1, 1, 'Distributed Database', 'Databases in the cloud'),
(3, 1, 'Thunder', 'more stuff in clouds'),
(5, 2, 'Thunder', 'test of duplicate names with different parent');

-- --------------------------------------------------------

--
-- Table structure for table `wa_users`
--

DROP TABLE IF EXISTS `wa_users`;
CREATE TABLE IF NOT EXISTS `wa_users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'AI User ID',
  `PW_HASH` varchar(40) NOT NULL COMMENT 'User PW SHA1 Hash',
  `FIRST_NAME` varchar(25) NOT NULL,
  `LAST_NAME` varchar(25) NOT NULL,
  `COMPANY` varchar(25) DEFAULT NULL,
  `ADDRESS_1` varchar(25) NOT NULL,
  `ADDRESS_2` varchar(25) DEFAULT NULL,
  `CITY` varchar(25) NOT NULL,
  `STATE` varchar(2) NOT NULL,
  `ZIP_CODE` varchar(10) NOT NULL,
  `PHONE_NUMBER` varchar(10) NOT NULL,
  `EMAIL` varchar(25) DEFAULT NULL COMMENT 'Required for login',
  `ADMIN` tinyint(1) NOT NULL DEFAULT '0',
  `ATTENDEE` tinyint(1) NOT NULL DEFAULT '0',
  `PRESENTER` tinyint(1) NOT NULL DEFAULT '0',
  `STUDENT` tinyint(1) NOT NULL DEFAULT '0',
  `REVIEWER` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `EMAIL` (`EMAIL`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Users of the WA Web App' AUTO_INCREMENT=52 ;

--
-- Dumping data for table `wa_users`
--

INSERT INTO `wa_users` (`ID`, `PW_HASH`, `FIRST_NAME`, `LAST_NAME`, `COMPANY`, `ADDRESS_1`, `ADDRESS_2`, `CITY`, `STATE`, `ZIP_CODE`, `PHONE_NUMBER`, `EMAIL`, `ADMIN`, `ATTENDEE`, `PRESENTER`, `STUDENT`, `REVIEWER`) VALUES
(1, '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Kevin', 'Miller', 'company', '123 Main', 'Line2', 'MyCity', 'MY', '12345', '1234567890', 'ksmiller99@gmail.com', 1, 1, 0, 0, 0),
(20, '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Kevin', 'Miller', 'Comp', 'Add1', 'Add2', 'Mycity', 'MY', '12345', '1234567890', 'neither@ab.com', 1, 0, 0, 0, 0),
(44, '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Kevin', 'Jones', 'Big', 'a1', 'a2', 'city', 'KY', '12345', '1234567890', 'hj@8.g', 1, 0, 0, 0, 0),
(46, '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Bob', 'Riff', 'Comp', 'Add1', '', '', '', '', '', 'a@a.a', 0, 0, 0, 0, 0),
(51, '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Bob', 'Riff', 'Comp', 'Add1', '', '', '', '', '', 'a@b.a', 0, 0, 0, 0, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `wa_orders`
--
ALTER TABLE `wa_orders`
  ADD CONSTRAINT `ORDER_USER_ID` FOREIGN KEY (`CUSTOMER_ID`) REFERENCES `wa_users` (`ID`);

--
-- Constraints for table `wa_order_details`
--
ALTER TABLE `wa_order_details`
  ADD CONSTRAINT `ORDER_DETAILS+ORDER_ID` FOREIGN KEY (`ORDER_ID`) REFERENCES `wa_orders` (`ID`),
  ADD CONSTRAINT `ORDER_DETAILS_PRODUCT_ID` FOREIGN KEY (`PRODUCT_ID`) REFERENCES `wa_products` (`ID`);

--
-- Constraints for table `wa_papers`
--
ALTER TABLE `wa_papers`
  ADD CONSTRAINT `FK_SUBAREA_SUBAREA` FOREIGN KEY (`SUBAREA_ID`) REFERENCES `wa_subareas` (`ID`),
  ADD CONSTRAINT `FK_USER_AUTHOR` FOREIGN KEY (`AUTHOR_ID`) REFERENCES `wa_users` (`ID`),
  ADD CONSTRAINT `FK_USER_REVEIWER` FOREIGN KEY (`REVIEWER_ID`) REFERENCES `wa_users` (`ID`);

--
-- Constraints for table `wa_subareas`
--
ALTER TABLE `wa_subareas`
  ADD CONSTRAINT `FK_AREA_SUBAREA` FOREIGN KEY (`PARENT_ID`) REFERENCES `wa_areas` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
