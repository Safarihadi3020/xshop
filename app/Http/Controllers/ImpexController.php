<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client;

class ImpexController extends Controller
{

    public $client;

    public $invLinks = array();

    public $proLinks = array();


    public function __construct()
    {
        $this->client = new Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false,),));
    }

    function getState($val)
    {



//        $b = array_search($val, $states);
//        if (!$b) {
//            return null;
//        }
//        return $b;
    }

    function getCity($val, $st)
    {


        $cities = array(1 => array(1 => 'اسکو', 2 => 'اهر', 3 => 'ایلخچی', 4 => 'آبش احمد', 5 => 'آذرشهر', 6 => 'آقکند', 7 => 'باسمنج', 8 => 'بخشایش', 9 => 'بستان آباد', 10 => 'بناب', 11 => 'بناب جدید', 12 => 'تبریز', 13 => 'ترک', 14 => 'ترکمانچای', 15 => 'تسوج', 16 => 'تیکمه داش', 17 => 'جلفا', 18 => 'خاروانا', 19 => 'خامنه', 20 => 'خراجو', 21 => 'خسروشهر', 22 => 'خضرلو', 23 => 'خمارلو', 24 => 'خواجه', 25 => 'دوزدوزان', 26 => 'زرنق', 27 => 'زنوز', 28 => 'سراب', 29 => 'سردرود', 30 => 'سهند', 31 => 'سیس', 32 => 'سیه رود', 33 => 'شبستر', 34 => 'شربیان', 35 => 'شرفخانه', 36 => 'شندآباد', 37 => 'صوفیان', 38 => 'عجب شیر', 39 => 'قره آغاج', 40 => 'کشکسرای', 41 => 'کلوانق', 42 => 'کلیبر', 43 => 'کوزه کنان', 44 => 'گوگان', 45 => 'لیلان', 46 => 'مراغه', 47 => 'مرند', 48 => 'ملکان', 49 => 'ملک کیان', 50 => 'ممقان', 51 => 'مهربان', 52 => 'میانه', 53 => 'نظرکهریزی', 54 => 'هادی شهر', 55 => 'هرگلان', 56 => 'هریس', 57 => 'هشترود', 58 => 'هوراند', 59 => 'وایقان', 60 => 'ورزقان', 61 => 'یامچی',), 2 => array(62 => 'ارومیه', 63 => 'اشنویه', 64 => 'ایواوغلی', 65 => 'آواجیق', 66 => 'باروق', 67 => 'بازرگان', 68 => 'بوکان', 69 => 'پلدشت', 70 => 'پیرانشهر', 71 => 'تازه شهر', 72 => 'تکاب', 73 => 'چهاربرج', 74 => 'خوی', 75 => 'دیزج دیز', 76 => 'ربط', 77 => 'سردشت', 78 => 'سرو', 79 => 'سلماس', 80 => 'سیلوانه', 81 => 'سیمینه', 82 => 'سیه چشمه', 83 => 'شاهین دژ', 84 => 'شوط', 85 => 'فیرورق', 86 => 'قره ضیاءالدین', 87 => 'قطور', 88 => 'قوشچی', 89 => 'کشاورز', 90 => 'گردکشانه', 91 => 'ماکو', 92 => 'محمدیار', 93 => 'محمودآباد', 94 => 'مهاباد', 95 => 'میاندوآب', 96 => 'میرآباد', 97 => 'نالوس', 98 => 'نقده', 99 => 'نوشین',), 3 => array(100 => 'اردبیل', 101 => 'اصلاندوز', 102 => 'آبی بیگلو', 103 => 'بیله سوار', 104 => 'پارس آباد', 105 => 'تازه کند', 106 => 'تازه کندانگوت', 107 => 'جعفرآباد', 108 => 'خلخال', 109 => 'رضی', 110 => 'سرعین', 111 => 'عنبران', 112 => 'فخرآباد', 113 => 'کلور', 114 => 'کوراییم', 115 => 'گرمی', 116 => 'گیوی', 117 => 'لاهرود', 118 => 'مشگین شهر', 119 => 'نمین', 120 => 'نیر', 121 => 'هشتجین', 122 => 'هیر',), 4 => array(123 => 'ابریشم', 124 => 'ابوزیدآباد', 125 => 'اردستان', 126 => 'اژیه', 127 => 'اصفهان', 128 => 'افوس', 129 => 'انارک', 130 => 'ایمانشهر', 131 => 'آران وبیدگل', 132 => 'بادرود', 133 => 'باغ بهادران', 134 => 'بافران', 135 => 'برزک', 136 => 'برف انبار', 137 => 'بهاران شهر', 138 => 'بهارستان', 139 => 'بوئین و میاندشت', 140 => 'پیربکران', 141 => 'تودشک', 142 => 'تیران', 143 => 'جندق', 144 => 'جوزدان', 145 => 'جوشقان و کامو', 146 => 'چادگان', 147 => 'چرمهین', 148 => 'چمگردان', 149 => 'حبیب آباد', 150 => 'حسن آباد', 151 => 'حنا', 152 => 'خالدآباد', 153 => 'خمینی شهر', 154 => 'خوانسار', 155 => 'خور', 157 => 'خورزوق', 158 => 'داران', 159 => 'دامنه', 160 => 'درچه', 161 => 'دستگرد', 162 => 'دهاقان', 163 => 'دهق', 164 => 'دولت آباد', 165 => 'دیزیچه', 166 => 'رزوه', 167 => 'رضوانشهر', 168 => 'زاینده رود', 169 => 'زرین شهر', 170 => 'زواره', 171 => 'زیباشهر', 172 => 'سده لنجان', 173 => 'سفیدشهر', 174 => 'سگزی', 175 => 'سمیرم', 176 => 'شاهین شهر', 177 => 'شهرضا', 178 => 'طالخونچه', 179 => 'عسگران', 180 => 'علویجه', 181 => 'فرخی', 182 => 'فریدونشهر', 183 => 'فلاورجان', 184 => 'فولادشهر', 185 => 'قمصر', 186 => 'قهجاورستان', 187 => 'قهدریجان', 188 => 'کاشان', 189 => 'کرکوند', 190 => 'کلیشاد و سودرجان', 191 => 'کمشچه', 192 => 'کمه', 193 => 'کهریزسنگ', 194 => 'کوشک', 195 => 'کوهپایه', 196 => 'گرگاب', 197 => 'گزبرخوار', 198 => 'گلپایگان', 199 => 'گلدشت', 200 => 'گلشهر', 201 => 'گوگد', 202 => 'لای بید', 203 => 'مبارکه', 204 => 'مجلسی', 205 => 'محمدآباد', 206 => 'مشکات', 207 => 'منظریه', 208 => 'مهاباد', 209 => 'میمه', 210 => 'نائین', 211 => 'نجف آباد', 212 => 'نصرآباد', 213 => 'نطنز', 214 => 'نوش آباد', 215 => 'نیاسر', 216 => 'نیک آباد', 217 => 'هرند', 218 => 'ورزنه', 219 => 'ورنامخواست', 220 => 'وزوان', 221 => 'ونک',), 5 => array(222 => 'اسارا', 223 => 'اشتهارد', 224 => 'تنکمان', 225 => 'چهارباغ', 226 => 'سیف آباد', 227 => 'شهر جدید هشتگرد', 228 => 'طالقان', 229 => 'کرج', 230 => 'کمال شهر', 231 => 'کوهسار', 232 => 'گرمدره', 233 => 'ماهدشت', 234 => 'محمدشهر', 235 => 'مشکین دشت', 236 => 'نظرآباد', 237 => 'هشتگرد', 1117 => 'فردیس', 1118 => 'مارلیک',), 6 => array(238 => 'ارکواز', 239 => 'ایلام', 240 => 'ایوان', 241 => 'آبدانان', 242 => 'آسمان آباد', 243 => 'بدره', 244 => 'پهله', 245 => 'توحید', 246 => 'چوار', 247 => 'دره شهر', 248 => 'دلگشا', 249 => 'دهلران', 250 => 'زرنه', 251 => 'سراب باغ', 252 => 'سرابله', 253 => 'صالح آباد', 254 => 'لومار', 255 => 'مهران', 256 => 'مورموری', 257 => 'موسیان', 258 => 'میمه',), 7 => array(259 => 'امام حسن', 260 => 'انارستان', 261 => 'اهرم', 262 => 'آب پخش', 263 => 'آبدان', 264 => 'برازجان', 265 => 'بردخون', 266 => 'بندردیر', 267 => 'بندردیلم', 268 => 'بندرریگ', 269 => 'بندرکنگان', 270 => 'بندرگناوه', 271 => 'بنک', 272 => 'بوشهر', 273 => 'تنگ ارم', 274 => 'جم', 275 => 'چغادک', 276 => 'خارک', 277 => 'خورموج', 278 => 'دالکی', 279 => 'دلوار', 280 => 'ریز', 281 => 'سعدآباد', 282 => 'سیراف', 283 => 'شبانکاره', 284 => 'شنبه', 285 => 'عسلویه', 286 => 'کاکی', 287 => 'کلمه', 288 => 'نخل تقی', 289 => 'وحدتیه',), 8 => array(290 => 'ارجمند', 291 => 'اسلامشهر', 292 => 'اندیشه', 293 => 'آبسرد', 294 => 'آبعلی', 295 => 'باغستان', 296 => 'باقرشهر', 297 => 'بومهن', 298 => 'پاکدشت', 299 => 'پردیس', 300 => 'پیشوا', 301 => 'تهران', 302 => 'جوادآباد', 303 => 'چهاردانگه', 304 => 'حسن آباد', 305 => 'دماوند', 306 => 'دیزین', 307 => 'ری', 308 => 'رباط کریم', 309 => 'رودهن', 310 => 'شاهدشهر', 311 => 'شریف آباد', 312 => 'شمشک', 313 => 'شهریار', 314 => 'صالح آباد', 315 => 'صباشهر', 316 => 'صفادشت', 317 => 'فردوسیه', 318 => 'فشم', 319 => 'فیروزکوه', 320 => 'قدس', 321 => 'قرچک', 322 => 'کهریزک', 323 => 'کیلان', 324 => 'گلستان', 325 => 'لواسان', 326 => 'ملارد', 327 => 'میگون', 328 => 'نسیم شهر', 329 => 'نصیرآباد', 330 => 'وحیدیه', 331 => 'ورامین', 1116 => 'پرند',), 9 => array(332 => 'اردل', 333 => 'آلونی', 334 => 'باباحیدر', 335 => 'بروجن', 336 => 'بلداجی', 337 => 'بن', 338 => 'جونقان', 339 => 'چلگرد', 340 => 'سامان', 341 => 'سفیددشت', 342 => 'سودجان', 343 => 'سورشجان', 344 => 'شلمزار', 345 => 'شهرکرد', 346 => 'طاقانک', 347 => 'فارسان', 348 => 'فرادبنه', 349 => 'فرخ شهر', 350 => 'کیان', 351 => 'گندمان', 352 => 'گهرو', 353 => 'لردگان', 354 => 'مال خلیفه', 355 => 'ناغان', 356 => 'نافچ', 357 => 'نقنه', 358 => 'هفشجان',), 10 => array(359 => 'ارسک', 360 => 'اسدیه', 361 => 'اسفدن', 362 => 'اسلامیه', 363 => 'آرین شهر', 364 => 'آیسک', 365 => 'بشرویه', 366 => 'بیرجند', 367 => 'حاجی آباد', 368 => 'خضری دشت بیاض', 369 => 'خوسف', 370 => 'زهان', 371 => 'سرایان', 372 => 'سربیشه', 373 => 'سه قلعه', 374 => 'شوسف', 375 => 'طبس ', 376 => 'فردوس', 377 => 'قاین', 378 => 'قهستان', 379 => 'محمدشهر', 380 => 'مود', 381 => 'نهبندان', 382 => 'نیمبلوک',), 11 => array(383 => 'احمدآباد صولت', 384 => 'انابد', 385 => 'باجگیران', 386 => 'باخرز', 387 => 'بار', 388 => 'بایگ', 389 => 'بجستان', 390 => 'بردسکن', 391 => 'بیدخت', 392 => 'تایباد', 393 => 'تربت جام', 394 => 'تربت حیدریه', 395 => 'جغتای', 396 => 'جنگل', 397 => 'چاپشلو', 398 => 'چکنه', 399 => 'چناران', 400 => 'خرو', 401 => 'خلیل آباد', 402 => 'خواف', 403 => 'داورزن', 404 => 'درگز', 405 => 'در رود', 406 => 'دولت آباد', 407 => 'رباط سنگ', 408 => 'رشتخوار', 409 => 'رضویه', 410 => 'روداب', 411 => 'ریوش', 412 => 'سبزوار', 413 => 'سرخس', 414 => 'سفیدسنگ', 415 => 'سلامی', 416 => 'سلطان آباد', 417 => 'سنگان', 418 => 'شادمهر', 419 => 'شاندیز', 420 => 'ششتمد', 421 => 'شهرآباد', 422 => 'شهرزو', 423 => 'صالح آباد', 424 => 'طرقبه', 425 => 'عشق آباد', 426 => 'فرهادگرد', 427 => 'فریمان', 428 => 'فیروزه', 429 => 'فیض آباد', 430 => 'قاسم آباد', 431 => 'قدمگاه', 432 => 'قلندرآباد', 433 => 'قوچان', 434 => 'کاخک', 435 => 'کاریز', 436 => 'کاشمر', 437 => 'کدکن', 438 => 'کلات', 439 => 'کندر', 440 => 'گلمکان', 441 => 'گناباد', 442 => 'لطف آباد', 443 => 'مزدآوند', 444 => 'مشهد', 445 => 'ملک آباد', 446 => 'نشتیفان', 447 => 'نصرآباد', 448 => 'نقاب', 449 => 'نوخندان', 450 => 'نیشابور', 451 => 'نیل شهر', 452 => 'همت آباد', 453 => 'یونسی',), 12 => array(454 => 'اسفراین', 455 => 'ایور', 456 => 'آشخانه', 457 => 'بجنورد', 458 => 'پیش قلعه', 459 => 'تیتکانلو', 460 => 'جاجرم', 461 => 'حصارگرمخان', 462 => 'درق', 463 => 'راز', 464 => 'سنخواست', 465 => 'شوقان', 466 => 'شیروان', 467 => 'صفی آباد', 468 => 'فاروج', 469 => 'قاضی', 470 => 'گرمه', 471 => 'لوجلی',), 13 => array(472 => 'اروندکنار', 473 => 'الوان', 474 => 'امیدیه', 475 => 'اندیمشک', 476 => 'اهواز', 477 => 'ایذه', 478 => 'آبادان', 479 => 'آغاجاری', 480 => 'باغ ملک', 481 => 'بستان', 482 => 'بندرامام خمینی', 483 => 'بندرماهشهر', 484 => 'بهبهان', 485 => 'ترکالکی', 486 => 'جایزان', 487 => 'چمران', 488 => 'چویبده', 489 => 'حر', 490 => 'حسینیه', 491 => 'حمزه', 492 => 'حمیدیه', 493 => 'خرمشهر', 494 => 'دارخوین', 495 => 'دزآب', 496 => 'دزفول', 497 => 'دهدز', 498 => 'رامشیر', 499 => 'رامهرمز', 500 => 'رفیع', 501 => 'زهره', 502 => 'سالند', 503 => 'سردشت', 504 => 'سوسنگرد', 505 => 'شادگان', 506 => 'شاوور', 507 => 'شرافت', 508 => 'شوش', 509 => 'شوشتر', 510 => 'شیبان', 511 => 'صالح شهر', 512 => 'صفی آباد', 513 => 'صیدون', 514 => 'قلعه تل', 515 => 'قلعه خواجه', 516 => 'گتوند', 517 => 'لالی', 518 => 'مسجدسلیمان', 520 => 'ملاثانی', 521 => 'میانرود', 522 => 'مینوشهر', 523 => 'هفتگل', 524 => 'هندیجان', 525 => 'هویزه', 526 => 'ویس',), 14 => array(527 => 'ابهر', 528 => 'ارمغان خانه', 529 => 'آب بر', 530 => 'چورزق', 531 => 'حلب', 532 => 'خرمدره', 533 => 'دندی', 534 => 'زرین آباد', 535 => 'زرین رود', 536 => 'زنجان', 537 => 'سجاس', 538 => 'سلطانیه', 539 => 'سهرورد', 540 => 'صائین قلعه', 541 => 'قیدار', 542 => 'گرماب', 543 => 'ماه نشان', 544 => 'هیدج',), 15 => array(545 => 'امیریه', 546 => 'ایوانکی', 547 => 'آرادان', 548 => 'بسطام', 549 => 'بیارجمند', 550 => 'دامغان', 551 => 'درجزین', 552 => 'دیباج', 553 => 'سرخه', 554 => 'سمنان', 555 => 'شاهرود', 556 => 'شهمیرزاد', 557 => 'کلاته خیج', 558 => 'گرمسار', 559 => 'مجن', 560 => 'مهدی شهر', 561 => 'میامی',), 16 => array(562 => 'ادیمی', 563 => 'اسپکه', 564 => 'ایرانشهر', 565 => 'بزمان', 566 => 'بمپور', 567 => 'بنت', 568 => 'بنجار', 569 => 'پیشین', 570 => 'جالق', 571 => 'چابهار', 572 => 'خاش', 573 => 'دوست محمد', 574 => 'راسک', 575 => 'زابل', 576 => 'زابلی', 577 => 'زاهدان', 578 => 'زهک', 579 => 'سراوان', 580 => 'سرباز', 581 => 'سوران', 582 => 'سیرکان', 583 => 'علی اکبر', 584 => 'فنوج', 585 => 'قصرقند', 586 => 'کنارک', 587 => 'گشت', 588 => 'گلمورتی', 589 => 'محمدان', 590 => 'محمدآباد', 591 => 'محمدی', 592 => 'میرجاوه', 593 => 'نصرت آباد', 594 => 'نگور', 595 => 'نوک آباد', 596 => 'نیک شهر', 597 => 'هیدوچ',), 17 => array(598 => 'اردکان', 599 => 'ارسنجان', 600 => 'استهبان', 601 => 'اشکنان', 602 => 'افزر', 603 => 'اقلید', 604 => 'امام شهر', 605 => 'اهل', 606 => 'اوز', 607 => 'ایج', 608 => 'ایزدخواست', 609 => 'آباده', 610 => 'آباده طشک', 611 => 'باب انار', 612 => 'بالاده', 613 => 'بنارویه', 614 => 'بهمن', 615 => 'بوانات', 616 => 'بیرم', 617 => 'بیضا', 618 => 'جنت شهر', 619 => 'جهرم', 620 => 'جویم', 621 => 'زرین دشت', 622 => 'حسن آباد', 623 => 'خان زنیان', 624 => 'خاوران', 625 => 'خرامه', 626 => 'خشت', 627 => 'خنج', 628 => 'خور', 629 => 'داراب', 630 => 'داریان', 631 => 'دبیران', 632 => 'دژکرد', 633 => 'دهرم', 634 => 'دوبرجی', 635 => 'رامجرد', 636 => 'رونیز', 637 => 'زاهدشهر', 638 => 'زرقان', 639 => 'سده', 640 => 'سروستان', 641 => 'سعادت شهر', 642 => 'سورمق', 643 => 'سیدان', 644 => 'ششده', 645 => 'شهرپیر', 646 => 'شهرصدرا', 647 => 'شیراز', 648 => 'صغاد', 649 => 'صفاشهر', 650 => 'علامرودشت', 651 => 'فدامی', 652 => 'فراشبند', 653 => 'فسا', 654 => 'فیروزآباد', 655 => 'قائمیه', 656 => 'قادرآباد', 657 => 'قطب آباد', 658 => 'قطرویه', 659 => 'قیر', 660 => 'کارزین (فتح آباد)', 661 => 'کازرون', 662 => 'کامفیروز', 663 => 'کره ای', 664 => 'کنارتخته', 665 => 'کوار', 666 => 'گراش', 667 => 'گله دار', 668 => 'لار', 669 => 'لامرد', 670 => 'لپویی', 671 => 'لطیفی', 672 => 'مبارک آباددیز', 673 => 'مرودشت', 674 => 'مشکان', 675 => 'مصیری', 676 => 'مهر', 677 => 'میمند', 678 => 'نوبندگان', 679 => 'نوجین', 680 => 'نودان', 681 => 'نورآباد', 682 => 'نی ریز', 683 => 'وراوی',), 18 => array(684 => 'ارداق', 685 => 'اسفرورین', 686 => 'اقبالیه', 687 => 'الوند', 688 => 'آبگرم', 689 => 'آبیک', 690 => 'آوج', 691 => 'بوئین زهرا', 692 => 'بیدستان', 693 => 'تاکستان', 694 => 'خاکعلی', 695 => 'خرمدشت', 696 => 'دانسفهان', 697 => 'رازمیان', 698 => 'سگزآباد', 699 => 'سیردان', 700 => 'شال', 701 => 'شریفیه', 702 => 'ضیاآباد', 703 => 'قزوین', 704 => 'کوهین', 705 => 'محمدیه', 706 => 'محمودآباد نمونه', 707 => 'معلم کلایه', 708 => 'نرجه',), 19 => array(709 => 'جعفریه', 710 => 'دستجرد', 711 => 'سلفچگان', 712 => 'قم', 713 => 'قنوات', 714 => 'کهک',), 20 => array(715 => 'آرمرده', 716 => 'بابارشانی', 717 => 'بانه', 718 => 'بلبان آباد', 719 => 'بوئین سفلی', 720 => 'بیجار', 721 => 'چناره', 722 => 'دزج', 723 => 'دلبران', 724 => 'دهگلان', 725 => 'دیواندره', 726 => 'زرینه', 727 => 'سروآباد', 728 => 'سریش آباد', 729 => 'سقز', 730 => 'سنندج', 731 => 'شویشه', 732 => 'صاحب', 733 => 'قروه', 734 => 'کامیاران', 735 => 'کانی دینار', 736 => 'کانی سور', 737 => 'مریوان', 738 => 'موچش', 739 => 'یاسوکند',), 21 => array(740 => 'اختیارآباد', 741 => 'ارزوئیه', 742 => 'امین شهر', 743 => 'انار', 744 => 'اندوهجرد', 745 => 'باغین', 746 => 'بافت', 747 => 'بردسیر', 748 => 'بروات', 749 => 'بزنجان', 750 => 'بم', 751 => 'بهرمان', 752 => 'پاریز', 753 => 'جبالبارز', 754 => 'جوپار', 755 => 'جوزم', 756 => 'جیرفت', 757 => 'چترود', 758 => 'خاتون آباد', 759 => 'خانوک', 760 => 'خورسند', 761 => 'درب بهشت', 762 => 'دهج', 763 => 'رابر', 764 => 'راور', 765 => 'راین', 766 => 'رفسنجان', 767 => 'رودبار', 768 => 'ریحان شهر', 769 => 'زرند', 770 => 'زنگی آباد', 771 => 'زیدآباد', 772 => 'سیرجان', 773 => 'شهداد', 774 => 'شهربابک', 775 => 'صفائیه', 776 => 'عنبرآباد', 777 => 'فاریاب', 778 => 'فهرج', 779 => 'قلعه گنج', 780 => 'کاظم آباد', 781 => 'کرمان', 782 => 'کشکوئیه', 783 => 'کهنوج', 784 => 'کوهبنان', 785 => 'کیانشهر', 786 => 'گلباف', 787 => 'گلزار', 788 => 'لاله زار', 789 => 'ماهان', 790 => 'محمدآباد', 791 => 'محی آباد', 792 => 'مردهک', 793 => 'مس سرچشمه', 794 => 'منوجان', 795 => 'نجف شهر', 796 => 'نرماشیر', 797 => 'نظام شهر', 798 => 'نگار', 799 => 'نودژ', 800 => 'هجدک', 801 => 'یزدان شهر',), 22 => array(802 => 'ازگله', 803 => 'اسلام آباد غرب', 804 => 'باینگان', 805 => 'بیستون', 806 => 'پاوه', 807 => 'تازه آباد', 808 => 'جوان رود', 809 => 'حمیل', 810 => 'ماهیدشت', 811 => 'روانسر', 812 => 'سرپل ذهاب', 813 => 'سرمست', 814 => 'سطر', 815 => 'سنقر', 816 => 'سومار', 817 => 'شاهو', 818 => 'صحنه', 819 => 'قصرشیرین', 820 => 'کرمانشاه', 821 => 'کرندغرب', 822 => 'کنگاور', 823 => 'کوزران', 824 => 'گهواره', 825 => 'گیلانغرب', 826 => 'میان راهان', 827 => 'نودشه', 828 => 'نوسود', 829 => 'هرسین', 830 => 'هلشی',), 23 => array(831 => 'باشت', 832 => 'پاتاوه', 833 => 'چرام', 834 => 'چیتاب', 835 => 'دهدشت', 836 => 'دوگنبدان', 837 => 'دیشموک', 838 => 'سوق', 839 => 'سی سخت', 840 => 'قلعه رئیسی', 841 => 'گراب سفلی', 842 => 'لنده', 843 => 'لیکک', 844 => 'مادوان', 845 => 'مارگون', 846 => 'یاسوج',), 24 => array(847 => 'انبارآلوم', 848 => 'اینچه برون', 849 => 'آزادشهر', 850 => 'آق قلا', 851 => 'بندرترکمن', 852 => 'بندرگز', 853 => 'جلین', 854 => 'خان ببین', 855 => 'دلند', 856 => 'رامیان', 857 => 'سرخنکلاته', 858 => 'سیمین شهر', 859 => 'علی آباد کتول', 860 => 'فاضل آباد', 861 => 'کردکوی', 862 => 'کلاله', 863 => 'گالیکش', 864 => 'گرگان', 865 => 'گمیش تپه', 866 => 'گنبدکاووس', 867 => 'مراوه', 868 => 'مینودشت', 869 => 'نگین شهر', 870 => 'نوده خاندوز', 871 => 'نوکنده',), 25 => array(872 => 'ازنا', 873 => 'اشترینان', 874 => 'الشتر', 875 => 'الیگودرز', 876 => 'بروجرد', 877 => 'پلدختر', 878 => 'چالانچولان', 879 => 'چغلوندی', 880 => 'چقابل', 881 => 'خرم آباد', 882 => 'درب گنبد', 883 => 'دورود', 884 => 'زاغه', 885 => 'سپیددشت', 886 => 'سراب دوره', 887 => 'فیروزآباد', 888 => 'کونانی', 889 => 'کوهدشت', 890 => 'گراب', 891 => 'معمولان', 892 => 'مومن آباد', 893 => 'نورآباد', 894 => 'ویسیان',), 26 => array(895 => 'احمدسرگوراب', 896 => 'اسالم', 897 => 'اطاقور', 898 => 'املش', 899 => 'آستارا', 900 => 'آستانه اشرفیه', 901 => 'بازار جمعه', 902 => 'بره سر', 903 => 'بندرانزلی', 906 => 'پره سر', 907 => 'تالش', 908 => 'توتکابن', 909 => 'جیرنده', 910 => 'چابکسر', 911 => 'چاف و چمخاله', 912 => 'چوبر', 913 => 'حویق', 914 => 'خشکبیجار', 915 => 'خمام', 916 => 'دیلمان', 917 => 'رانکوه', 918 => 'رحیم آباد', 919 => 'رستم آباد', 920 => 'رشت', 921 => 'رضوانشهر', 922 => 'رودبار', 923 => 'رودبنه', 924 => 'رودسر', 925 => 'سنگر', 926 => 'سیاهکل', 927 => 'شفت', 928 => 'شلمان', 929 => 'صومعه سرا', 930 => 'فومن', 931 => 'کلاچای', 932 => 'کوچصفهان', 933 => 'کومله', 934 => 'کیاشهر', 935 => 'گوراب زرمیخ', 936 => 'لاهیجان', 937 => 'لشت نشا', 938 => 'لنگرود', 939 => 'لوشان', 940 => 'لولمان', 941 => 'لوندویل', 942 => 'لیسار', 943 => 'ماسال', 944 => 'ماسوله', 945 => 'مرجقل', 946 => 'منجیل', 947 => 'واجارگاه',), 27 => array(948 => 'امیرکلا', 949 => 'ایزدشهر', 950 => 'آلاشت', 951 => 'آمل', 952 => 'بابل', 953 => 'بابلسر', 954 => 'بالاده', 955 => 'بهشهر', 956 => 'بهنمیر', 957 => 'پل سفید', 958 => 'تنکابن', 959 => 'جویبار', 960 => 'چالوس', 961 => 'چمستان', 962 => 'خرم آباد', 963 => 'خلیل شهر', 964 => 'خوش رودپی', 965 => 'دابودشت', 966 => 'رامسر', 967 => 'رستمکلا', 968 => 'رویان', 969 => 'رینه', 970 => 'زرگرمحله', 971 => 'زیرآب', 972 => 'ساری', 973 => 'سرخرود', 974 => 'سلمان شهر', 975 => 'سورک', 976 => 'شیرگاه', 977 => 'شیرود', 978 => 'عباس آباد', 979 => 'فریدونکنار', 980 => 'فریم', 981 => 'قائم شهر', 982 => 'کتالم', 983 => 'کلارآباد', 984 => 'کلاردشت', 985 => 'کله بست', 986 => 'کوهی خیل', 987 => 'کیاسر', 988 => 'کیاکلا', 989 => 'گتاب', 990 => 'گزنک', 991 => 'گلوگاه', 992 => 'محمودآباد', 993 => 'مرزن آباد', 994 => 'مرزیکلا', 995 => 'نشتارود', 996 => 'نکا', 997 => 'نور', 998 => 'نوشهر', 1119 => 'سادات شهر',), 28 => array(999 => 'اراک', 1000 => 'آستانه', 1001 => 'آشتیان', 1002 => 'پرندک', 1003 => 'تفرش', 1004 => 'توره', 1005 => 'جاورسیان', 1006 => 'خشکرود', 1007 => 'خمین', 1008 => 'خنداب', 1009 => 'داودآباد', 1010 => 'دلیجان', 1011 => 'رازقان', 1012 => 'زاویه', 1013 => 'ساروق', 1014 => 'ساوه', 1015 => 'سنجان', 1016 => 'شازند', 1017 => 'غرق آباد', 1018 => 'فرمهین', 1019 => 'قورچی باشی', 1020 => 'کرهرود', 1021 => 'کمیجان', 1022 => 'مامونیه', 1023 => 'محلات', 1024 => 'مهاجران', 1025 => 'میلاجرد', 1026 => 'نراق', 1027 => 'نوبران', 1028 => 'نیمور', 1029 => 'هندودر',), 29 => array(1030 => 'ابوموسی', 1031 => 'بستک', 1032 => 'بندرجاسک', 1033 => 'بندرچارک', 1034 => 'بندرخمیر', 1035 => 'بندرعباس', 1036 => 'بندرلنگه', 1037 => 'بیکا', 1038 => 'پارسیان', 1039 => 'تخت', 1040 => 'جناح', 1041 => 'حاجی آباد', 1042 => 'درگهان', 1043 => 'دهبارز', 1044 => 'رویدر', 1045 => 'زیارتعلی', 1046 => 'سردشت', 1047 => 'سندرک', 1048 => 'سوزا', 1049 => 'سیریک', 1050 => 'فارغان', 1051 => 'فین', 1052 => 'قشم', 1053 => 'قلعه قاضی', 1054 => 'کنگ', 1055 => 'کوشکنار', 1056 => 'کیش', 1057 => 'گوهران', 1058 => 'میناب', 1059 => 'هرمز', 1060 => 'هشتبندی',), 30 => array(1061 => 'ازندریان', 1062 => 'اسدآباد', 1063 => 'برزول', 1064 => 'بهار', 1065 => 'تویسرکان', 1066 => 'جورقان', 1067 => 'جوکار', 1068 => 'دمق', 1069 => 'رزن', 1070 => 'زنگنه', 1071 => 'سامن', 1072 => 'سرکان', 1073 => 'شیرین سو', 1074 => 'صالح آباد', 1075 => 'فامنین', 1076 => 'فرسفج', 1077 => 'فیروزان', 1078 => 'قروه درجزین', 1079 => 'قهاوند', 1080 => 'کبودر آهنگ', 1081 => 'گل تپه', 1082 => 'گیان', 1083 => 'لالجین', 1084 => 'مریانج', 1085 => 'ملایر', 1086 => 'نهاوند', 1087 => 'همدان',), 31 => array(1088 => 'ابرکوه', 1089 => 'احمدآباد', 1090 => 'اردکان', 1091 => 'اشکذر', 1092 => 'بافق', 1093 => 'بفروئیه', 1094 => 'بهاباد', 1095 => 'تفت', 1096 => 'حمیدیا', 1097 => 'خضرآباد', 1098 => 'دیهوک', 1099 => 'زارچ', 1100 => 'شاهدیه', 1101 => 'طبس', 1103 => 'عقدا', 1104 => 'مروست', 1105 => 'مهردشت', 1106 => 'مهریز', 1107 => 'میبد', 1108 => 'ندوشن', 1109 => 'نیر', 1110 => 'هرات', 1111 => 'یزد',),);
        $b = array_search($val, $cities[$st]);
        if (!$b) {
            return null;
        }
        return $b;
//        $c = [];
//        foreach ($cities as $city) {
//            $c[$city['state_id']][$city['id']] = $city['name'];
//        }
//        var_export($c);
    }

    //
    function customer()
    {

        $cs =  [];

        $txt = '';
        foreach ($cs as $c) {

            $txt .= $c[3] . '<hr>';
            if (Customer::where('id', $c[1])->orWhere('mobile', $c[4])->count() == 0) {
                $cn = new Customer();
                $cn->id = $c[1];
            } else {
                $cn = Customer::where('id', $c[1])->orWhere('mobile', $c[4])->first();
            }
            $cn->name = trim($c[3]);
            $cn->email = null;
            $cn->mobile = trim($c[4]);
            $cn->colleague = 0;
            $cn->state = $this->getState(trim($c[6]));
            if ($cn->state != null) {
                $cn->city = $this->getCity(trim($c[7]), $cn->state);
            }
            $cn->address = trim($c[8]);
            $cn->postal_code = trim($c[9]);
            $cn->save();
        }

        return $txt;
    }

    function col()
    {
        $cs = [];

        $txt = '';
        foreach ($cs as $c) {

            $txt .= $c[3] . '<hr>';
            if (Customer::where('id', $c[1])->orWhere('mobile', $c[4])->count() == 0) {
                $cn = new Customer();
                $cn->id = $c[1];
            } else {
                $cn = Customer::where('id', $c[1])->orWhere('mobile', $c[4])->first();
            }
            $cn->name = trim($c[2]);
            $cn->email = null;
            $cn->mobile = trim($c[4]);
            $cn->colleague = 1;
            $cn->state = null;
            $cn->city = null;
            $cn->address = null;
            $cn->postal_code = null;
            $cn->description = $c[3];
            $cn->save();
        }
        return $txt;
    }

    function getPage($url)
    {

        $jar = \GuzzleHttp\Cookie\CookieJar::fromArray(
            [
                'ny_ny_sntral_session' => 'eyJpdiI6Ik1qT3B1ZVdRWnVWeG4rb0JTMFlKR0E9PSIsInZhbHVlIjoibWtlVjc3VGtHTU54bVFPN3JEZXdzQ1pROTJHQzFnUnB3TVZhY2NEZEZwa05jYXRXdkpLRVZsSzlGWjdYeXIrcCtqMW5lbm1iMWVZNWRPY0YwL0lMZ0hhbkIxUFRhMW5jNHdCNXN1ZVFTV1RmcHpRTUIrSDJNd2lTUjRkK2hlejEiLCJtYWMiOiI5YTAwYzgzNzM3N2IzNTNmZjRiYTUxZDRhOGQ1YTMyZWQ2NzhhYzQ1OWM0ZDg0YmM3MmVkYTFjNDFjMjA3MTQ1In0%3D',
                'nynysntral_session' => 'eyJpdiI6Im5ha2h2ZTJ3QTRrTzBCT0FTOTk1TVE9PSIsInZhbHVlIjoib21uYmw5alFGMVNaUFlrOFFhTjY4eGZVTERqYzhmWWxhRzlFalpJU053NW1STWkveXpPK21HM0NhRi80ZVNMV0RsKzVCeE1PUlcyZTd5MUhOWFpYZVpRNkFWQ0tjcWlLWTdIK1FUTW9lVUhxS2gzZXlCUXZKbTl0UnN0UVpJUG4iLCJtYWMiOiI4ZTQ2MGUzYzk2NGQ5Yjc1NDJlOTQwMTAyNmFhMTM2ZWY2Yjc4NWQwMDVjNjNlZTAyYjY2NGFjOWMwZGVkNGU1IiwidGFnIjoiIn0%3D',
                'XSRF-TOKEN' => 'eyJpdiI6IlZ4enFDazVkL3UycERkeVZxbmlVNlE9PSIsInZhbHVlIjoia0tQbFppOXFlbWc0SUdjekwrVkxhODc2UlNVaEx2RzAwemEyUjl3NS93bUFYaFYwekplaElXem5mSHhwSWxEbUY5aGJuSFZxYU8vSTd5V0YrbkxLbVlWQ28zZ2xnQ1doT0VTTWdjQ21YeitJdkJsMDhyZG1ELzFhWVc3aFEwMmwiLCJtYWMiOiI1OWVmNGMxZmMzYjdhNDQ1ODUyNzFjNzU2ZTY1OTVkM2IxMzRiODkzMGM5MjNlZDBkYzcwYTI4YjlkZDM0NDNjIn0%3D',
            ],
            'ninicenteral.com'
        );
        $res = $this->client->request('GET', $url, [
            'cookies' => $jar,
        ]);


//        echo $res->getStatusCode();
// "200"
//        echo $res->getHeader('content-type')[0];
// 'application/json; charset=utf8'
        if  ($res->getStatusCode() == 200){
            return $res->getBody();
        }else{
            return  false;
        }
    }


    function crwl()
    {
        $links = [];
//
//        for ($i = 1; $i <= 16; $i++) {
//            $html = $this->getPage('https://ninicenteral.com/ninicenteral/product?page=' . $i);
//            $crawler = new Crawler($html);
//
////        $x = $crawler->filter("table.table-hover tr td:nth-child(4) a")->first()
//            foreach ($crawler->filter("table.table-hover tr td:nth-child(4) a") as $k => $el) {
//                $node = new Crawler($el);
//                $n = $k + 1;
//                $id = $crawler->filter("table.table-hover tr:nth-child({$n}) td:nth-child(1)")->first()->innerText();
//                $links[$id] = $node->attr('href');
//            }
//        }


//        $links = array_reverse($links);
        var_export($links);
//        var_dump($x);
    }

    function crwl2()
    {
        $links = [];

//        for ($i = 1; $i <= 37; $i++) {
//            $html = $this->getPage('https://ninicenteral.com/ninicenteral/order/all?page=' . $i);
//            $crawler = new Crawler($html);
//
//            //$id = $crawler->filter("table.table-hover tr:nth-child({$n}) td:nth-child(1)")->first()->innerText();
////        $x = $crawler->filter("table.table-hover tr td:nth-child(4) a")->first()
//            foreach ($crawler->filter("table.table-hover tr td:nth-child(7) a") as $k => $el) {
//                $node = new Crawler($el);
//                if ($node->filter("table.table-hover tr:nth-child({$k}) .badge-danger")->count() == 0) {
//                    $links[] = $node->attr('href');
//                }
//            }
//        }


        $links = array_reverse($links);
        var_export($links);
//        var_dump($x);
    }

//
//$cats = json_decode('[
//  {
//    "id": "1",
//    "text": "پوشاک پاییزه زمستونی"
//  },
//  {
//    "id": "7",
//    "text": "  زمستانی دخترانه"
//  },
//  {
//    "id": "3",
//    "text": "دخترانه  بلوز شلوار "
//  },
//  {
//    "id": "4",
//    "text": " دخترانه هودی شلوار "
//  },
//  {
//    "id": "5",
//    "text": "دخترانه سویشرت شلوار "
//  },
//  {
//    "id": "8",
//    "text": "  زمستانی پسرانه"
//  },
//  {
//    "id": "9",
//    "text": "پسراته بلوز شلوار "
//  },
//  {
//    "id": "10",
//    "text": " پسرانه  هودی شلوار "
//  },
//  {
//    "id": "12",
//    "text": "  پسرانه سویشرت شلوار "
//  },
//  {
//    "id": "13",
//    "text": "پوشاک بهاره تابستانه"
//  },
//  {
//    "id": "14",
//    "text": "  تاسبتانی پسرانه"
//  },
//  {
//    "id": "15",
//    "text": "پسرانه  تیشرت و شلوارک "
//  },
//  {
//    "id": "16",
//    "text": "  تابستانی دخترانه"
//  },
//  {
//    "id": "17",
//    "text": "دخترانه  تیشرت و شلوارک "
//  },
//  {
//    "id": "18",
//    "text": "حراجی تک سایز"
//  }
//]');
//foreach ($cats as $cat){
//$c = new Cat();
//$c->id = $cat->id;
//$c->name = $cat->text;
//$c->slug =  \StarterKit::slug($cat->text);
//$c->save();
//}

    function getPro()
    {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
//        $k = 2;
        foreach ($this->proLinks as $k => $url) {
//            if ($k <= 0){
//                continue;
//            }
            $url = $this->proLinks[$k];
            usleep(300000);
            $html = $this->getPage($url);
            if  ($html != false){
                $crawler = new Crawler($html);


                if ($crawler->filter('#inputState option:selected')->first()->attr('value') != 'تحویل به پست') {
                    continue;
                }
                $p = new Product();
                $p->id = $k;
                $p->name = $crawler->filter('#title')->first()->attr('value');
                $p->active = true;
                $p->excerpt = $p->name;
                $part = explode('/', $url);
                $p->slug = urldecode($part[count($part) - 1]);
                $p->description = str_replace('html', 'div', $crawler->filter('#textarea')->first()->innerText());
                $cats = [];
                $crawler->filter('#select option:selected')->each(function ($node) use (&$cats) {
                    $cats[] = $node->attr('value');
                });
                $p->cat_id = $cats[0];
                $p->user_id = User::first()->id;
                $p->save();
                $p->syncMeta(['type' => $crawler->filter('#type_id option:selected')->first()->attr('value')]);
                $p->categories()->sync($cats);
                $crawler->filter('img.m-2')->each(function ($node) use (&$p) {
                    $pUrl = $node->attr('src');
                    $this->client->request('GET', $pUrl, [
                        'sink' => storage_path('test.jpg')
                    ]);
                    $p->addMedia(storage_path('test.jpg'))->toMediaCollection();
                });
                $p->save();
                print $p->name . ' Done! <hr>';
            }else{
                print  $k.' | '.$url.' skip: <hr>';
            }

        }
    }

    public function getInv()
    {
        ini_set('max_execution_time', 0);
        set_time_limit(0);
        foreach ($this->invLinks as $i => $url) {

            $html = $this->getPage($url); // coleage
//        $html = $this->getPage('https://ninicenteral.com/ninicenteral/order/1451');
//        $html = $this->getPage('https://ninicenteral.com/ninicenteral/order/1473');


            $crawler = new Crawler($html);
            $inv = new Invoice();
            $inv->transport_id = 1;
            $inv->transport_price = $crawler->filter('.pc.mx-3.d-inline')->first()->innerText();
            $inv->total_price = $crawler->filter('.pc.b')->first()->text();
            $inv->status = 'COMPLETED';
            $inv->hash = md5(time() . $inv->total_price . rand(0, 9999));
            // $('.border-1 span').length
            if ($crawler->filter('.border-1 span')->count() == 39) {
                // hamkarr
                $number = $crawler->filter('.border-1 .b.mr-3')->eq(8)->innerText();
                $inv->desc = $crawler->filter('.border-1 .b.mr-3')->eq(4)->innerText().', ';
                $inv->desc .= $crawler->filter('.border-1 .b.mr-3')->eq(5)->innerText().', ';
                $inv->desc .= $crawler->filter('.border-1 .b.mr-3')->eq(6)->innerText();
            } else {
                $number = $crawler->filter('.border-1 span')->eq(7)->innerText();
            }
            $inv->tracking_code = $crawler->filter('#tracking_code')->first()->attr('value');

            if (Customer::where('mobile', trim($number))->count() == 0) {
                $inv->customer_id = null;
            } else {
                $inv->customer_id = Customer::where('mobile', trim($number))->first()->id;
            }
            $inv->save();

            $crawler->filter('.scroll-x tr')->each(function ($node) use (&$inv) {
//            $node = new Crawler($el);
                if ($node->filter('td')->count() > 4) {

                    $id = trim($node->filter('td:first-child')->innerText());
                    $p = Product::where('id', $id)->first();
                    if ($p != null) {
                        $inv->products()->save(
                            $p,
                            [
                                'count' => $node->filter('td:nth-child(4)')->innerText(),
                                'price_total' => $node->filter('td:nth-child(5)')->innerText(),
                            ]
                        );
                    }
//                echo $node->filter('td:nth-child(3)')->innerText() . '<br>';
                }
            });

            echo $i . $url . ' Done! <hr>';
        }

    }

    public function login(){
        return \Auth::guard('customer')->loginUsingId(Customer::inRandomOrder()->first()->id);
    }
    public function loginas($tel){
        return \Auth::guard('customer')->loginUsingId(Customer::whereMobile($tel)->first()->id);
    }
}
