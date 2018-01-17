<div class="mb-nav-b">
  <div class="top"><img src="/inc/img/used/corp_filter_results.png" alt="Filter Results" /></div>
  <ul>
    <li><a href="/mercedes/used/" class="expanded">Used Vehicles</a>
      <ul>
        <li><a href="/mercedes/used/vans/">Vans (<?=$count_van?>)</a></li>
        <li><a href="/mercedes/used/trucks/">Trucks (<?=$count_truck?>)</a></li>
      </ul>
    </li>
    <li><a href="/mercedes/used/" class="expanded">Categories</a>
      <ul>
        <? foreach($categorys as $category) { ?>
        <li><a href="/mercedes/used/c/<?=$category['addr']?>/"><?=$category['category']?> (<?=$category['count']?>)</a></li>
        <? } ?>
      </ul>
    </li>
    <li><a href="/mercedes/used/" class="expanded">Models</a>
      <ul>
        <? foreach($models as $model) { ?>
        <li><a href="/mercedes/used/m/<?=$model['addr']?>/"><?=$model['name']?> (<?=$model['count']?>)</a></li>
        <? } ?>
      </ul>
    </li>
  </ul>
  <div class="bottom"></div>
</div>
<div class="banner">
  <a href="/mercedes/ex-demonstrators/">
    <img src="/inc/img/used/exdemo.jpg">
  </a>
</div>
<div class="banner">
  <a href="/mercedes/used/signup">
    <img src="/inc/img/used/newsletter.jpg">
  </a>
</div>
<div class="banner">
  <a href="/mercedes/used/contact">
    <img src="/inc/img/used/contact.jpg">
  </a>
</div>
<style type="text/css" media="all">
     div.mb-nav-b .top img { margin-top: 7px; }  
     div.banner { margin: 10px; }  
</style>
