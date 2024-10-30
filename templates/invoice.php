<!DOCTYPE html>
<html lang="zxx" dir="ltr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">       
	<style>
		
html {
	scroll-behavior: smooth;
	-webkit-text-size-adjust: 100%;
}
body {
	background: #F8F9FD;
	width: auto;
	height: 100%;
	color: #ffffff;
	font-family: 'Inter', sans-serif;
	margin: 0;
}

*, ::after, ::before {
	box-sizing: border-box;
}
a:focus, a {
	outline: none;
	text-decoration: none;
	color: #ffffff;
	cursor: pointer;
} 
a.contact_focus,
a.email_focus{
	color: #12151C;
}
svg,img {
	vertical-align: middle;
}
section{
	padding: 10px 0;
	position: relative;
	width: 100%;
	height: 100%;
}
.mtb-0 {
	margin-bottom: 0;
	margin-top: 0;
}
.medium-font {
	font-size: 16px;
	line-height: 24px;
}
.md-lg-font {
	font-size: 20px;
	line-height: 24px;
}
.sm-text{
	font-size: 18px;
	line-height: 24px;
}
.sm-md-text {
	font-size: 14px;
	line-height: 22px;
}
.b-text {
	color: #12151C;
}
.second-color {
	color: #505050;
}
.primary-color {
	color: #00BAFF;
}
.third-color {
	color: #A2A2A2;
}
/************************* 2.Header CSS **************************/

.inter-400 {
	font-weight: 400;
}
.inter-700 {
	font-weight: 700;
}
.inter-500 {
	font-weight: 500;
}
.invoice-container {
	max-width: 880px;
	margin: 0 auto;
	padding: 30px 15px;
}
.content-min-width{
	background: #12151C;
	border-radius: 20px 20px 0 0;
	padding:20px 50px 30px;
}
.logo img {
	height: 60px;
	width: auto;
}
.invoice-logo-content {
	display: flex;
	flex-wrap: nowrap;
	align-content: center;
	justify-content: space-between;
	align-items: center;
}
.invo-head-wrap {
	display: flex;
	justify-content: space-between;
	align-items: center;
}
.invoice-content-wrap {
	background: #fff;
	position: relative;
	height: 100%;
	width: 100%;
}
.invo-num-title {
	width: 60%;
}
.invo-no {
	width: 50%;
	font-size: 16px;
	line-height: 24px;
}
.invo-num {
	color: #FFFFFF;
	padding-left: 20px;
	font-size: 16px;
	line-height: 24px;
}
.invo-num-dark {
	color: #A2A2A2;
	padding-left: 20px;
	font-size: 16px;
	line-height: 24px;
}

.invo-head-wrap.invoi-date-wrap {
	margin-top: 20px;
}
.invo-cont-wrap {
	display: flex;
	flex-wrap: nowrap;
	align-items: center;
}
.invoice-header-contact {
	display: inline-flex;
	padding-top: 36px;
}
.invo-cont-wrap.invo-contact-wrap {
	margin-right: 30px;
}
.invo-social-name {
	padding-left: 10px;
}
.text-invoice {
	background-image: url('../images/header/back-img.svg');
	background-repeat: no-repeat;
	width: 100%;
	height: auto;
	top: auto;
	bottom: 0;
	left: 0;
	right: 0;
	background-size: auto;
	background-position: bottom center;
}


/************************* 3.Invoice Content CSS **************************/

.container {
	max-width: 850px;
	margin: 0 auto;
	padding: 0 50px;
}
.invo-to {
	color: #12151C;
}
.invo-to-owner {
	color: #00BAFF;
	margin: 10px 0;
}
.invoice-owner-conte-wrap {
	display: flex;
	justify-content: space-between;
	-webkit-box-pack: justify;
}
.invo-to-wrap {
	text-align: left;
}
.invo-pay-to-wrap {
	text-align: right;
}
.invo-owner-address {
	color: #505050;
}
.table-wrapper {
	padding: 30px 0 20px;
}
.invoice-table {
	border-collapse: collapse;
	width: 100%;
	max-width: 750px;
	margin: 0 auto;
	white-space: nowrap;
	background-color: #ffffff;
}
.invoice-table td, .invoice-table th {
	text-align: left;
}
.invoice-table td {
	color: #505050;
	font-size: 14px;
	line-height: 22px;
	padding: 20px 0;
}
td.invo-tb-data.third-color{
	color: #A2A2A2;
}
.invoice-table-dark td {
	color: #505050;
	/*color: #A2A2A2;*/
	font-size: 14px;
	line-height: 22px;
	padding: 20px 0;
}
.invoice-table thead th {
	color: #12151C;
	padding: 10px 0;
}
.invo-tb-body .invo-tb-row {
	border-bottom: 1px solid #888888;
}
.invo-tb-body .invo-tb-row:last-child {
	border-bottom: none;
}
.invo-tb-body {
	border-bottom: 2px solid #12151C;
	border-top: 2px solid #12151C;
}
.serv-wid {
	width: 32%;
}
.desc-wid {
	width: 36%;
}
.qty-wid {
	width: 10%;
}
.pric-wid {
	width: 12%;
}
.tota-wid {
	width: 10%;
}
.invoice-table th.total-head, .invoice-table td.total-data {
	text-align: right;
}
.addi-info-title {
	color: #12151C;
	margin: 0 0 10px;
}
.add-info-desc {
	font-size: 14px;
	line-height: 22px;
	color: #505050;
}
.add-info-desc-dark {
	font-size: 14px;
	line-height: 22px;
	color: #A2A2A2;
}

.invo-total-price {
	font-weight: 500;
}
.invo-addition-wrap {
	display: flex;
}
.invo-add-info-content {
	width: 50%;
}
 
.invo-bill-total table {
	width: 100%;
	border-collapse: collapse; 
}
.invo-total-table td.invo-total-data, .invo-total-table td.invo-total-price{
	text-align: right;
}
.tax-row.bottom-border, .disc-row.bottom-border {
	border-bottom: 2px solid #12151C;
}
.hotel-sub {
	padding-left: 70px!important;
}
.invo-total-table .tax-row td, .invo-grand-total td {
	padding: 20px 0;
}

/************************* 4.Bottom Content CSS **************************/

.agency-bottom-content {
	background: #12151c;
	border-radius: 0px 0px 20px 20px;
	padding: 20px 0;
}
.invo-btns {
	display: inline-flex;
	align-items: center;
	margin: 0 1px;
}
.invo-buttons-wrap {
	display: flex;
	justify-content: center;
	align-items: center;
}
.invo-buttons-wrap .invo-btns .print-btn {
	background: #00BAFF;
	padding: 12px 24px;
	border-radius: 24px 0px 0px 24px;
	display: -webkit-inline-box;
	display: -ms-inline-flexbox;
	display: inline-flex;
	-webkit-box-align: center;
	-ms-flex-align: center;
}   
.invo-buttons-wrap .invo-btns .download-btn {
	background: #00D061;
	padding: 12px 24px;
	border-radius: 0px 24px 24px 0px;
	display: -webkit-inline-box;
	display: -ms-inline-flexbox;
	display: inline-flex;
	-webkit-box-align: center;
	-ms-flex-align: center;
}
.invo-btns span {
	padding-left: 10px;
}
.invo-note-wrap, .note-title {
	display: flex;
	align-items: center;
}
.invo-note-wrap {
	padding-top: 10px;
}
.note-title span, .note-desc {
	padding-left: 10px;
}

/************************* 5.Hotel Booking CSS **************************/

.item-wid {
	width: 18%;
}
.invoice-table th.rate-title, .invoice-table td.rate-data {
	text-align: center;
}
.invo-hotel-title, .invo-hotel-desc {
	font-size: 14px;
	line-height: 22px;
}
.detail-col {
	width: 247px;
	background: #F5F5F5;
	padding: 9px 10px;
}
.booking-content-wrap {
	display: flex;
	justify-content: space-between;
}
.booking-content-wrap.second-row {
	padding-top: 4px;
}
.invo-hotel-book-wrap {
	padding-top: 50px;
}
.payment-desc {
	font-size: 14px;
	line-height: 22px;
	padding: 20px 0 10px;
}
.payemnt-wid, .date-wid, .trans-wid, .amount-wid {
	width: 33.33%;
	text-align: left;
	padding: 10px 0;
}
.invo-payment-table {
	border-collapse: collapse;
}
.payment-table-wrap {
	padding: 10px 20px;
	background: #F5F5F5;
	margin-top: 35px;
	position: relative;
	z-index: 10;
}
.invo-paye-row {
	border-top: 2px solid #12151C;
}

/************************* 6.Restaurant Bill CSS **************************/

.invoice-header.back-img-invoice {
	content: '';
	position: relative;
	background-image: url('../images/header/back-img-one.png');
	width: 100%;
	height: auto;
	top: 0;
	bottom: auto;
	left: 0;
	right: 0;
	background-repeat: no-repeat;
	background-position: center center;
	background-size: cover;
}
.invoice-header.back-img-invoice:before, 
.invoice-header.stadium-header:before,
.invoice-header.car-header-img:before {
	content: '';
	position: absolute;
	background-color: #12151C;
	opacity: 0.8;
	width: 100%;
	height: 100%;
	left: 0;
	right: 0;
	top: 0;
	border-radius: 20px 20px 0px 0px;
}
.back-img-invoice .invoice-logo-content, 
.back-img-invoice .invoice-header-contact,
.car-header-img .invoice-logo-content,
.car-header-img .invoice-header-contact{
	position: relative;
	z-index: 8;
}
.sno-wid  {
	width: 14%;
}
.re-desc-wid {
	width: 22%;
}
.re-price-wid {
	width: 14%;
}
.re-qty-wid {
	width: 15%;
}
.discount-price {
	color: #00D061;
}
.disc-row td {
	padding-bottom: 20px;
}
.payment-wrap {
	border: 2px solid #12151C;
	padding: 0px 20px 0px 20px;
	display: inline-block;
}
.res-pay-table {
	border-collapse: collapse;
}
.pay-data {
	border-bottom: 1px solid #888888;
}
.pay-type {
	padding: 20px 20px 20px 0px;
}
.refund-days {
	padding: 20px 0 20px 0px;
}
.res-pay-table tbody .pay-data:last-child {
	border-bottom: none;
}
.rest-payment-bill {
	display: flex;
}
.sign-img img, .money-img img  {
	width: 100%;
	height: auto;
}
.signature-wrap {
	text-align: center;
	align-items: center;
	position: relative;
	left: 19%;
	padding-top: 50px;
}
.manager-name {
	font-weight: 500;
	font-size: 14px;	
	line-height: 22px;
}
.thank-you-content {
	text-align: center;
	padding-top: 50px;
	font-size: 14px;	
	line-height: 22px;
}

/************************* 7. Bus Booking CSS **************************/

.content-min-width.bus-header {
	padding: 20px 50px 0px;
}
.content-min-width.bus-header .invoice-logo{
	position: relative;
	top: -9px;
}
.bus-invo-no-date-wrap {
	background-color: #00BAFF;
	padding: 8px 50px;
	display: flex;
	justify-content: space-between;	
}
.bus-invo-nnum, .bus-invo-ddate {
	padding-left: 10px;
}
.invoice-timing-wrap {
	display: flex;
	justify-content: flex-start;
}
.invo-time-col {
	width: 50%;
	display: inline-block;
	padding: 0 12px 0 18px;
	position: relative;
}
.booking-info p, .booking-info {
	position: relative;
}
.booking-info .circle:before {
	content: '';
	position: absolute;
	width: 8px;
	height: 8px;
	border-radius: 50px;
	background-color: #00BAFF;
	left: -16px;
	top: 7px;
}
.booking-info:before {
	content: '';
	position: absolute;
	border-left: 2px solid #00baff;
	height: 39px;
	top: 12px;
	left: -13px;
}
.invoice-timing-wrap {
	padding: 26px 0 50px;
}
.bus-detail-col {
	display: inline-flex;
}
.bus-detail-col.border-bottom {
	border-bottom: 1px solid #888888;
	padding-bottom: 20px;
}
.bus-detail-wrap {
	display: grid;
	grid-column: 2;
	grid-template-columns: auto auto auto auto;
	gap: 20px 30px;
	grid-row: 2;
	grid-template-columns: repeat(2, 1fr);
	padding: 30px;
	border: 2px solid #12151C;
}
.bus-type, .invo-add-info-content.bus-term-cond-content, .invo-bill-total.bus-invo-total {
	width: 50%;
}
.term-con-list {
	padding: 0 0 0 16px;
	margin: 0;
}
.bus-conta-mail-wrap {
	display: flex;
	align-items: center;
	justify-content: space-between;
	padding: 30px 0 0;
}
.bus-contact a, .bus-mail a {
	vertical-align: middle;
}

/************************* 8. Money Exchange CSS **************************/

.content-min-width.money-header {
	padding: 10px 50px 10px;
}
.money-detail-wrap {
	margin: 50px 0;
}
.transfer-title {
	border-bottom: 2px solid #12151C;
	padding-bottom: 10px;
}
.left-money-top-row {
	padding-right: 100px;
}
.left-money-bottom-row {
	padding-right: 50px;
}
.transfer-detail-wrap {
	display: flex;
	justify-content: space-between;
}
.tra-money {
	color: #12151C;
}
.tra-title {
	padding: 10px 0 5px 0;
}
.tra-money {
	padding: 5px 0 10px;
}
.money-tran-title-wrap {
	padding: 0 0 20px 0;
}
.right-money-block {
	display: flex;
	align-items: center;
}
.money-col-one {
	padding: 0 25px 0 0;
	display: flex;
	flex-wrap: wrap;
	flex-direction: column;
}
.money-col-two {
	padding: 0 25px 0;
}
.money-col-three {
	padding: 0 0 0 25px;
	display: flex;
	flex-wrap: wrap;
	flex-direction: column;
}
.money-content {
	text-transform: uppercase;
	padding-bottom: 10px;
}
.right-money-transfer {
	border: 2px solid #12151C;
	padding: 20px 20px 10px;
}
.mon-exchange-rate {
	padding-bottom: 20px;
}
.transfer-wrap {
	padding: 0 0 50px 0;
}
.mon-sent-content-wrap {
	display: flex;
	align-items: center;
	padding: 15px 0 0;
}
.mon-send-left-data {
	padding-right: 150px;
}
.mon-send-col-one, .mon-send-col-two {
	padding: 5px 0;
}
.paid-out-title-wrap {
	padding-top: 50px;
}
.mon-paid-left-data {
	padding-right: 120px;
}

/************************* 9. Money Exchange CSS **************************/

.invo-tb-body.hosp-tb-body {
	border-bottom: none;
}
.hosp-invo-table {
	background-color: #F5F5F5;
}
.hosp-invo-table .invo-tb-header{
	background-color: #f5f5f5;
}
.invoice-table.hospital-table th.rate-title, .invoice-table.hospital-table td.rate-data {
	text-align: left
}
.invoice-table.hospital-table .sno-wid{
	width: 2%;
}
.invoice-table.hospital-table .re-price-wid {
	width: 20%;
}
.invoice-table.hospital-table .re-qty-wid,.invoice-table.hospital-table .tota-wid {
	width: 5%;
}
.hosp-back-img-one img {
	position: absolute;
	left: auto;
	right: 20px;
	top: 20px;
	z-index: 10;
}
.hospital-service-content .table-wrapper.patient-table-wrapper {
	z-index: 26;
	position: relative;
}
.hosp-back-img-two img {
	position: absolute;
	bottom: 20px;
	left: 20px;
	right: auto;
}
.table-wrapper.patient-detail-wrapper {
	padding-bottom: 0;
}
.hospital-table-wrap {
	margin-top: 50px;
}
.left-money-transfer {
	display: flex;
}

/************************* 10. Movie Ticket Booking CSS **************************/

.movie-details-wrap {
	position: relative;
	display: flex;
	width: 100%;
	padding: 50px 0 0;
	column-gap: 30px;
	align-items: center;
}
.movie-col-left,.movie-col-right {
	width: 50%;
}
.movie-img img {
	border-radius: 10px;
	width: 100%;
	height: auto;
}
.movie-detail-col {
	display: inline-flex;
	align-items: center;
	padding: 10px 0;
}
.movie-col-right {
	display: flex;
	flex-direction: column;
	flex-wrap: wrap;
}
.movie-detail-col .movie-name{
	width: 120px;
}
.invo-addition-wrap.movi-add-wrap {
	justify-content: flex-end;
}
.invo-addition-wrap.movi-add-wrap .invo-grand-total td {
	padding: 0;
}
.invoice-table.movie-table .re-desc-wid {
	width: 40%;	
}
.invoice-table.movie-table .re-price-wid {
	width: 10%;	
}
.invoice-table.movie-table .re-qty-wid {
	width: 10%;	
}
.invoice-table.movie-table .re-tax-wid {
	width: 10%;	
}
.invoice-table.movie-table .tota-wid {
	width: 15%
}
.invoice-table.movie-table th.rate-title, .invoice-table.movie-table td.rate-data, 
.invoice-table.movie-payment-table th.re-desc-wid, .invoice-table.movie-payment-table td.rate-data.movi-pay-card,
.invoice-table.booker-table th.rate-title, .invoice-table.booker-table td.rate-data {
	text-align: left;	
}
.invoice-table.movie-table th.re-qty-wid.rate-title, .invoice-table.movie-table th.re-tax-wid.rate-title,
.invoice-table.movie-table .invo-tb-data.qty-data, .invoice-table.movie-table .invo-tb-data.tax-data,
.invoice-table.booker-table .tota-wid, .invoice-table.booker-table .invo-tb-data.total-data {
	text-align: center;
}
.invo-addition-wrap.movi-add-wrap .hotel-sub {
	padding-left: 50px!important;
}
.invoice-table.movie-payment-table .invo-tb-row td {
	padding: 0;
}
.invoice-table.movie-payment-table .re-desc-wid {
	width: 12%;
}
.invoice-table.movie-payment-tabl .re-price-wid {
	width: 12%;
}
.must-read-desc  {
	padding-top: 10px;
}
.movie-must-read-wrap {
	padding-top: 30px;
}

/************************* 11. Stadium Seat Booking CSS **************************/

.invoice-header.stadium-header.content-min-width {
	padding: 50px;
}

.invoice-header.stadium-header .invoice-logo-content{
	justify-content: center;
}
.invoice-header.stadium-header {
	background-image: url('../images/header/back-img-two.png');
	width: 100%;
	height: auto;
	top: 0;
	bottom: auto;
	left: 0;
	right: 0;
	background-repeat: no-repeat;
	background-position: center center;
	background-size: cover;
	position: relative;
	content: '';
}
.invoice-header.stadium-header:before  {
	opacity: 0.6;
}
.invoice-logo-content {
	position: relative;
}
.booker-title-wrap {
	padding: 0;
}
.booker-table-wrap {
	padding: 0;
}
.invoice-table.booker-table .sno-wid{
	width: 8%;
}
.invoice-table.booker-table .re-price-wid  {
	width: 30%;
}
.invoice-table.booker-table .re-qty-wid, .invoice-table.booker-table  .tota-wid  {
	width: 6%;
}
.invo-addition-wrap.booking-grand-total {
	padding-top: 20px;
}
.invo-addition-wrap.booking-grand-total .hotel-sub  {
	padding-left: 35px!important;
}
@media print {
	.d-print-none {
		display: none!important;
	}
}

/************************* 12. Dark Invoice CSS **************************/
.invoice-dark {
	background-color: #000000;
}
.dark-invoice-content-wrap {
	background-color: #000000;
}
.dark-content-section {
	background-color: #21242B;
}
.w-text,  .dark-table tr th {
	color: #ffffff;
}
.dark-table .invoice-table {
	background-color: #21242B;
}
.dark-table  .invo-tb-body {
	border-bottom: 2px solid #ffffff;
	border-top: 2px solid #ffffff;
}
.invo-bill-total.dark-invo-bill .tax-row.bottom-border, .dark-invo-bill .disc-row.bottom-border {
	border-bottom: 2px solid #ffffff;
}
.dark-bus-detail-wrap, .dark-money-detail-wrap, .dark-money-exchange, .dark-payment-bill-wrap .payment-wrap,
.dark-money-details-wrap{
	border: 2px solid #ffffff;
}
.payment-table-wrap.dark-table, .dark-payment-wrap,
.dark-invo-book-wrap .detail-col, .dark-money-detail-wrap {
	background: #12151C;
}
.hospital-table-wrap.dark-table .invo-paye-row, .hotel-booking-wrap.dark-table .invo-paye-row,
.dark-payment-wrap .invo-paye-row,
{
	border-top: 2px solid #ffffff;
}
.dark-title .transfer-title{
	border-bottom: 2px solid #ffffff;
}
.detail-col-car1.detail-col-car1-dark{
	background: #12151C;
}
.table-color.dark-table-color tr:nth-child(odd){
	background: #12151C;
}
.photostudio-detail-wrap.photostudio-detail-wrap-dark {
	background: #12151c;
}
.dark-bottom-white-border{
	border-bottom: 2px solid #FFFFFF;
}

/************************* 13.Flight Booking CSS **************************/
.content-min-width.flight-header{
	padding: 20px 50px;
}
.flight-table-wrap{
	margin-top: 0;
	padding: 20px;
}
.payemnt-wid-flight,
.date-wid-flight,
.trans-wid-flight,
.amount-wid-flight{
	width: 33.33%;
	text-align: left;
	padding: 20px 0 10px;
} 
table.invo-payment-table.invo-payment-table {
	width: 100%;
}
.text-center{
	text-align: center;
}
.invoice-timing-wrap.invoice-timing-wrap-flight {
	padding: 50px 0;
}
.flight-margin{
	margin: 0;
}
.mb{
	margin-bottom: 20px;
}
.flight-pt{
	padding: 0 0 10px;
	width: 25%;
}
.payment-desc.payment-desc{
	padding: 20px 0 0;
}
.thank-you-content.thank-you-content {
	padding-top: 30px;
}
.flight-img img {
	width: 100%;
	height: auto;
}
/************************* 14. Car Booking CSS **************************/
.car-header-img{
	content: '';
	position: relative;
	background-image: url(../images/car/car-header-img.png);
	width: 100%;
	height: auto;
	top: 0;
	bottom: auto;
	left: 0;
	right: 0;
	background-repeat: no-repeat;
	background-position: center center;
	background-size: cover;
}
.car-mt{
	margin-top: 10px;
}
.detail-col-car{
	background: rgb(0 186 255 / 10%);
	width: 230px;
	padding: 20px;
}
.invo-car-book-wrap {
	padding: 50px 0 50px;
}
.detail-col-car1{
	padding: 9px 10px;
    background: #F5F5F5;
    margin: 1px;
}
.invo-car-book-wrap.invo-car-book-wrap{
	padding-bottom: 40px;
}
.hire-mt {
	padding: 50px 0;
}
.payment-wrap.payment-wrap-car{
	width: 360px;
	margin-top: 30px;
}
.bus-conta-mail-wrap.car-conta-mail-wrap {
	padding-top: 50px;
}
.disply-none{
	display: none;
}
.mt-5{
	margin-top: 5px;
}
td.ptb-10{
	padding: 10px 0;
}

/************************* 15.Train Booking CSS **************************/
.train-table-wrap{
	padding: 20px;
	margin-top: 50px;
}
.mt{
	margin-top: 50px;
}

/************************* 16. Ecommerce Booking CSS **************************/
.ecommerce-header{
	padding: 10px 50px;
}

/************************* 17. Student Billing  CSS **************************/
.invoice-header.student_header .invoice-logo-content {
	justify-content: center;
}
.pl{
	padding-left: 20px;
}
.m-0{
	margin: 0;
	margin-bottom: 10px;
}
.invoice-header-contact.invoice-header-contact1 {
	display: flex;
	justify-content: space-between;
}

/************************* 18. Domain$Hosting CSS **************************/
.domain-header {
	padding: 10px 50px;
}
.domain-mt {
	padding-top: 50px;
}

/************************* 19. Internet Bill CSS **************************/
.mb-digital{
	margin-bottom: 10px;
}
.invo-add-info-content-internet {
	width: 100%;
}
.mt-30{
	margin-top: 30px;
}

/************************* 20. Coffee Shop CSS **************************/
.coffee_header{
	padding: 0 0 0 50px;
}
.p-0-coffee{
	padding: 0;
}

.coffee-shop-back-img-one img{
	position: absolute;
	left: 50%;
	top: 50%;
	transform: translate(-50%, -50%);
}

.coffee_bg{
	background-image: url(../images/coffee-shop/coffee-back-img1.png);
	background-repeat: no-repeat;
	background-position: center center;
	background-size: contain;
}
/************************* 21. Travel CSS **************************/
.travel_header {
	content: '';
	position: relative;
	background-image: url(../images/travel/travel-header-img.png);
	width: 100%;
	height: auto;
	top: 0;
	bottom: auto;
	left: 0;
	right: 0;
	background-repeat: no-repeat;
	background-position: center center;
	background-size: cover;
	padding: 50px;
}
.invoice-header.travel_header:before {
	content: '';
	position: absolute;
	background-color: #12151C;
	opacity: 0.6;
	width: 100%;
	height: 100%;
	left: 0;
	right: 0;
	top: 0;
	border-radius: 20px 20px 0px 0px;
}

/************************* 22. Fitness CSS **************************/
.fitness-header{
	padding: 10px 50px;
}

/************************* 23. Photo Studio CSS **************************/
.invoice-header-contact-photostudio{
	display: flex;
}
.photostudio-detail-wrap{
	background: #F5F5F5;
	border: 2px solid #00BAFF;
}
.invoice-table thead th.paddind-pt{
	padding: 10px 20px;
}
.table-color tr:nth-child(odd){
	background: #F5F5F5;
}
tr.paddind-pt-row td{
	padding: 20px;
}
.photostudio-header{
	padding: 10px 50px;
}

/************************* 24. Cleaning CSS **************************/
.cleaning-table-wrap{
	padding: 20px;
}
.cleaning-back-img-one img {
	position: absolute;
	left: auto;
	right: 20px;
	top: 20px;
	z-index: 10;
}
.cleaning-back-img-two img {
	position: absolute;
	bottom: 20px;
	left: 20px;
	right: auto;
}
	</style>
</head>
<body>
	<!--Invoice Wrap Start here -->
	 <div class="invoice_wrap"  width="100%"> 
			<div class="invoice-content-wrap">
				<!--Header Start Here -->
				<div class=" content-min-width">
						<table class="invoice-table ">
							<thead style="background: #12151C">
								<tr class="invo-tb-header" style="background: #12151C">
									<th class="invo-table-title inter-700 medium-font"  style="padding: 0"> </th>
									<th class="invo-table-title inter-700 medium-font"  style="padding: 0"> </th> 
								</tr>
							</thead>
							<tbody class="" style="background: #12151C">								 
								<tr class="invo-tb-row" style="background: #12151C">
									<td class="invo-tb-data"  style="padding: 0">
										<div class="invoice-logo">
									   	<h3 class="text-white"><?php  get_bloginfo('name'); ?></h3>
    					        		</div>
									</td> 
									<td class="invo-tb-data total-data"  style="padding: 0">
										<div class="invoice-header-contact">
											<div class="invo-cont-wrap invo-contact-wrap">
												<div class="invo-social-icon">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_6_94)"><path d="M5 4H9L11 9L8.5 10.5C9.57096 12.6715 11.3285 14.429 13.5 15.5L15 13L20 15V19C20 19.5304 19.7893 20.0391 19.4142 20.4142C19.0391 20.7893 18.5304 21 18 21C14.0993 20.763 10.4202 19.1065 7.65683 16.3432C4.8935 13.5798 3.23705 9.90074 3 6C3 5.46957 3.21071 4.96086 3.58579 4.58579C3.96086 4.21071 4.46957 4 5 4" stroke="#00BAFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M15 7C15.5304 7 16.0391 7.21071 16.4142 7.58579C16.7893 7.96086 17 8.46957 17 9" stroke="#00BAFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M15 3C16.5913 3 18.1174 3.63214 19.2426 4.75736C20.3679 5.88258 21 7.4087 21 9" stroke="#00BAFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></g><defs><clipPath id="clip0_6_94"><rect width="24" height="24" fill="white"/></clipPath></defs>
													</svg>
												</div>
												<div class="invo-social-name">
													<a href="tel:+12345678899" class="invo-hedaer-contact inter-400 sm-text">+1 234 567 8899</a>
												</div>
											</div>
											<div class="invo-cont-wrap">
												<div class="invo-social-icon">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_6_108)"><path d="M19 5H5C3.89543 5 3 5.89543 3 7V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V7C21 5.89543 20.1046 5 19 5Z" stroke="#00BAFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M3 7L12 13L21 7" stroke="#00BAFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></g><defs><clipPath id="clip0_6_108"><rect width="24" height="24" fill="white"/></clipPath></defs></svg>
												</div>
												<div class="invo-social-name">
													<a href="mailto:contact@invoice.com" class="invo-hedaer-mail inter-400 sm-text">contact@invoice.com</a>
												</div>
											</div>
										</div>
									</td>
								</tr>
							</tbody>
						</table>

				</div>
				<!--Header End Here -->
				<div class="bus-invo-no-date-wrap">
				   <table class="invoice-table ">
							<thead style="background: #00BAFF">
								<tr class="invo-tb-header" style="background: #00BAFF;">
									<th class="invo-table-title inter-700 medium-font" style="padding: 0"> </th>
									<th class="invo-table-title inter-700 medium-font" style="padding: 0"> </th> 
								</tr>
							</thead>
							<tbody class="" style="background: #00BAFF; color: #fff">								 
								<tr class="invo-tb-row" style="background: #00BAFF">
									<td class="invo-tb-data" style="padding: 0">
							     		<div class="bus-invo-num">
											<span class="bus-invo-ntitle inter-700 medium-font" style="color: #fff">Invoice No:</span>
											<span class="bus-invo-nnum inter-400 medium-font " style="color: #fff">#DI56789</span>
										</div>
									</td> 
									<td class="invo-tb-data total-data" style="padding: 0">
								    	<div class="bus-invo-date">
											<span class="bus-invo-dtitle inter-700 medium-font" style="color: #fff">Invoice Date:</span>
											<span class="bus-invo-ddate inter-400 medium-font" style="color: #fff">30/11/2022</span>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
				</div>

				<!--Invoice content start here -->
				<div class="ticket-booking-content" >
					<div class="container">
						<!--invoice owner name content -->
					 
						<table class="invoice-table">
							<thead>
								<tr class="invo-tb-header">
									<th class="invo-table-title inter-700 medium-font"> </th>
									<th class="invo-table-title inter-700 medium-font"> </th>
								 </tr>
							</thead>
							<tbody class="">								 
								<tr class="invo-tb-row">
									<td class="invo-tb-data">
										<div class="invo-to-wrap">
											<div class="invoice-to-content">
												<p class="invo-to inter-700 medium-font mtb-0">Facturé a:</p>
												<h1 class="invo-to-owner inter-700 md-lg-font"><?php _e( $customer_name) ?></h1>
												<p class="invo-owner-address medium-font inter-400 mtb-0">Phone: +1 562 563 8899 <br> Email: jordon123@mail.com</p>
											</div>
										</div>
									</td>
									<td class="invo-tb-data">			
										<div class="invo-pay-to-wrap">
											<div class="invoice-pay-content">
												<p class="inter-700 md-lg-font mtb-0 primary-color mb-digital">Digital Invoico LTD</p>
												<h2 class="disply-none">Display</h2>
												<p class="invo-owner-address medium-font inter-400 mtb-0">4510 E Dolphine St, IN 3526<br> Hills Road, New York, USA</p>
											</div>
										</div>
									</td> 
								</tr>
							</tbody>
						</table>
						<table class="invoice-table">
							<thead>
								<tr class="invo-tb-header">
									<th class="invo-table-title inter-700 medium-font" style="padding: 0"> </th>
									<th class="invo-table-title inter-700 medium-font" style="padding: 0"> </th>
									<th class="invo-table-title rate-title inter-700 medium-font" style="padding: 0"> </th>
								</tr>
							</thead>
							<tbody class="">								 
								<tr class="invo-tb-row">
									<td class="invo-tb-data">
										<div class=" detail-col-car1">
											<span class="sm-md-text book-id inter-700 invo-to" >Date:</span>
											<span class="add-info-desc inter-400"> </b>  <?php _e($date) ?></span>
										</div>
									</td>
									<td class="invo-tb-data">
										<div class=" detail-col-car1">
											<span class="sm-md-text check-in inter-700 invo-to">Créneaux:</span>
											<span class="add-info-desc inter-400"><?php _e($time) ?></span>
										</div>
									</td>
									<td class="invo-tb-data rate-data">
										<div class=" detail-col-car1">
											<span class="sm-md-text nights inter-700 invo-to">Package:</span>
											<span class="add-info-desc inter-400">Heure(s)</span>
										</div>
									</td> 
								</tr>
							</tbody>
						</table>

						<!--Internet Table Data Start here -->
						<div class="table-wrapper">
							<table class="invoice-table">
						 
								<thead>
									<tr class="invo-tb-header">
										<th class="invo-table-title inter-700 medium-font"> No</th>
										<th class="invo-table-title inter-700 medium-font">Service</th>
										 <th class="invo-table-title rate-title inter-700 medium-font">Prix</th>
									</tr>
								</thead>
								<tbody class="invo-tb-body">								 
									<tr class="invo-tb-row">
										<td class="invo-tb-data">1</td>
										<td class="invo-tb-data"><?php  _e($product_name) ?></td>
										 <td class="invo-tb-data total-data">
										 <span> <?php  _e($product_price) ?></span> <?php _e(get_woocommerce_currency_symbol()) ?>    

										 </td>
									</tr>
									<?php  
									var_dump($selected_extras); 
									if(!empty($selected_extras)){
											$i= 2;
												
											foreach($selected_extras as $extra){?>
												<tr class="invo-tb-row">
													<td class="invo-tb-data"><?php _e($i) ?></td>
													<td class="invo-tb-data"><?php  _e( $extra->nom)?></td> 
													<td class="invo-tb-data total-data">
													<span> <?php  _e( $extra->cout) ?></span> <?php _e(get_woocommerce_currency_symbol()) ?>    
													</td>
												</tr> 
								<?php $i++; } }?>
								</tbody>
							</table>
						</div>
						<!-- Internet Table Data End here -->

						<!--Invoice additional info start here -->
						<div class="">
							
							<table class="invoice-table">
								 
								<thead class="">								 
									<tr class="invo-tb-row"  style=" width: 100% ">
										<th class="invo-tb-data"  style=" width: 60%">
											<div>

											</div>
										</th>
										<th class="invo-tb-data"  style=" width: 40%"> 
											<div class="invo-bill-total ">
												<table class="invo-total-table">
													<tbody>
														<tr>
															<td class="inter-700 medium-font b-text hotel-sub">Sous Total:</td>
															<td class="invo-total-data inter-400 medium-font second-color">
																<span> <?php  _e($total) ?></span> <?php _e(get_woocommerce_currency_symbol()) ?>
												
															</td>
														</tr>
														<tr class="tax-row bottom-border">
															<td class="inter-700 medium-font b-text hotel-sub">Reduction</td>
															<td class="invo-total-data inter-400 medium-font second-color">
															<span> <?php  _e("0") ?></span> <?php _e(get_woocommerce_currency_symbol()) ?>
												
															</td>
														</tr>
														<tr class="invo-grand-total bottom-border" s>
															<td class="inter-700 sm-text primary-color hotel-sub" style="font-weight: 700; font-size: 18px;color:#00BAFF;padding-right: 10px;">Total:</td>
															<td class="sm-text b-text invo-total-price" style="font-weight: 700;">
														<span> <?php  _e($total) ?></span> <?php _e(get_woocommerce_currency_symbol()) ?>
												         </td>
														</tr>
													</tbody>
												</table>
											</div>
										</th> 
									</tr>
								</thead>
							</table>

							 
						
						</div>
		
					</div>
				</div>
				<div class="agency-bottom-content"> 
					<div class="invo-note-wrap" style="display:inline">
					
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_8_240)"><path d="M14 3V7C14 7.26522 14.1054 7.51957 14.2929 7.70711C14.4804 7.89464 14.7348 8 15 8H19" stroke="#00BAFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M17 21H7C6.46957 21 5.96086 20.7893 5.58579 20.4142C5.21071 20.0391 5 19.5304 5 19V5C5 4.46957 5.21071 3.96086 5.58579 3.58579C5.96086 3.21071 6.46957 3 7 3H14L19 8V19C19 19.5304 18.7893 20.0391 18.4142 20.4142C18.0391 20.7893 17.5304 21 17 21Z" stroke="#00BAFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 7H10" stroke="#00BAFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 13H15" stroke="#00BAFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M13 17H15" stroke="#00BAFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></g><defs><clipPath id="clip0_8_240"><rect width="24" height="24" fill="white"/>
							</clipPath></defs></svg>
							<span class="inter-700 medium-font">Note:</span>
						<span class="inter-400 medium-font third-color note-desc mtb-0" style="display:inline">
						Il s'agit d'un reçu généré par ordinateur qui ne nécessite pas de signature physique.</span>
					</div>
				</div>
			</div>
			</div>
			 
	</div>
	
</body>
</html>