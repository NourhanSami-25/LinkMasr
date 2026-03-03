<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta property="og:locale" content="en_US" />
<meta property="og:url" content="#" />
<meta name="csrf-token" content="{{ csrf_token() }}">

@if (app()->getLocale() == 'ar')
    <meta name="description"
        content="اكتشف لينك برو، أفضل برنامج لإدارة الشركات. حلول ذكية لتنظيم العمل، العملاء، التنبيهات، والفواتير بسهولة وكفاءة.">
    <meta name="keywords" content="لينك برو، برنامج إدارة الشركات، فواتير، تنبيهات">
    <meta property="og:title" content="لينك برو - أفضل برنامج لإدارة الشركات">
    <meta property="og:description" content="نظام CRM ذكي لإدارة الشركات، العملاء، الفواتير، التنبيهات بكفاءة.">
    <meta property="og:site_name" content="لينك برو لإدارة الشركات">
    <meta property="og:type" content="website">
@else
    <meta name="description"
        content="Discover Link Pro, the leading company management software. Smart solutions for organizing work, clients, alerts, and billing efficiently.">
    <meta name="keywords" content="Link Pro, Company Management, Billing, Alerts">
    <meta property="og:title" content="Link Pro - Best Company Management Software">
    <meta property="og:description"
        content="Smart CRM system for managing companies, clients, billing, and alerts efficiently.">
    <meta property="og:site_name" content="Link Pro Company Management">
    <meta property="og:type" content="website">
@endif