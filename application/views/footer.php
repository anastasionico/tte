<footer class="row">
  <div class="">
  	<h4>Parts</h4>
    <ul>
      <li><a href="/vehicles">Manufacturer</a></li> 
      <li><a href="/categories">Categories</a></li> 
      <li><a href="/offers_page">Offers</a></li> 
      <li><a href="/latest_page">Latest</a></li> 
      <li><a href="/bestseller_page">Best Seller</a></li> 
      <li><a href="/featured_page">Featured</a></li> 
    </ul>
  </div>
  <div class="">
    <h4>Sitemap</h4>
    <ul>
      <li><a href="/contact">Contact</a></li> 
      <li><a href="/terms">Terms &amp; Conditions</a></li>
      <li><a href="/cookies">Cookie Policy</a></li>
    </ul>
  </div>
  <div class="">
    <h4>Connect With Us</h4>
    <ul>
      <li>
        <a href="https://www.facebook.com/Trucktrailerequip" target="_blank">
          <i class="fa fa-facebook-square" aria-hidden="true"></i> &nbsp;&nbsp; Facebook 
        </a>
      </li>
      <li>
        <a href="mailto:sales@trucktrailerequip.co.uk" target="_top">
          <i class="fa fa-envelope" aria-hidden="true"></i> &nbsp;&nbsp; Mail Us 
        </a>
      </li>
      <li>
        <a href="tel:01386555203">
          <i class="fa fa-phone-square" aria-hidden="true"></i> &nbsp;&nbsp; Sales
        </a>
      </li>
      <li>
        <a href="tel:01215523541">
          <i class="fa fa-phone-square" aria-hidden="true"></i> &nbsp;&nbsp; Accounts
        </a>
      </li>
      <li>
        <a href="tel:01215555863">
          <i class="fa fa-fax" aria-hidden="true"></i> &nbsp;&nbsp; Fax
        </a>
      </li>
    </ul>
  </div>
  <div id="copyright">
  	For Consumer complaints not finance-related, and you feel your complaint has not been resolved by us in a satisfactory manner, you can refer your complaint to an Alternative Dispute Resolution provider. In the event, Imperial Commercials recommend and intend to use the following: 
The National Conciliation Service, Retail Motor Industry Federation Ltd, 2nd Floor, Chestnut Field House, Chestnut Field, Rugby, Warwickshire. CV21 2PA
  </div>
</footer>

<script type="text/html" id="basketpart">
  <% var linetotal = Number(price) * Number(qty); %>
  <tr>
    <td><input type="text" name="<%=id%>" value="<%=qty%>" class="quantity form-control"></td>
    <td>
      <div class="ptitle"><%=title%></div>
      <div class="pnumber"><%=part_no%></div>
      <div><a href="#" class="btn btn-danger btn-xs checkout-delete">Delete</a></div>
    </td>
    <td><%=price.toFixed(2)%></td>
    <td class="text-right">
      £<span class="pprice"><%=linetotal.toFixed(2)%></span>
    </td>
  </tr>
</script>
<script src="/assets/js/jquery.mixitup.min.js"></script>
<script src="/assets/js/parts.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    loadSessionBasket();
  });

  function addedCart(clicked_button){
    var addButton = document.getElementById(clicked_button);
    console.log(addButton);
    addButton.value = "Done";
    window.setTimeout(function(){addButton.value = "Add More";}, 1000);
    

    var alertDiv = document.createElement("div");
    var sectionOffer = document.getElementsByTagName('body')[0];
    alertDiv.className += "alert alert-success text-center";
    alertDiv.innerHTML = "<h1>Added to Cart</h1><div class='alert-success--continue'><a href='#'  data-dismiss='alert' aria-label='close'>Continue browsing <br><i class='fa fa-plus-square' aria-hidden='true'></i></a></div><div class='alert-success--cart'><a href='/checkout/cart' class=''>Go to the Cart <br><i class='fa fa-shopping-cart' aria-hidden='true'></i></a></div>";
    

    sectionOffer.appendChild(alertDiv);
  } 
</script>
</body>
</html>