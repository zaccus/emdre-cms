<?php
error_reporting(E_ALL);
		ini_set('display_errors', '1');
?>

<!-- Begin For Sale Listings View -->

    <div id="listings-for-sale">
        
        <table id="propertyTable">
            <tr>
                <th>Address</th>
                <th>Price</th>
                <th>Blurb</th>
            </tr>
        </table>
        
        <div id="add-listing" class="modal hidden">
            
            <label>Select a property:
                <select id="property-select">
                    <option id="newProperty">New Property</option>
                </select>
            </label>
            
            <div id="property-info">
                Address: <input id='address' class='property-input'> <br>
                City: <input id='city' class='property-input'><br>
                Beds: <input id='beds' class='property-input'><br>
                Baths: <input id='baths' class='property-input'><br>
                SqFt: <input id='sqft' class='property-input'><br>
                Acres: <input id='acres' class='property-input'>
            </div>
            
            <div id="sales-info">
                Price: <input id='price' class='sales-input'><br>
                Blurb: <input id='blurb' class='sales-input'><br>
                Comments: <textarea id='comments' class='sales-input' cols='50' rows='10'></textarea>
            </div>
            
            <input id='save' type='button' value='submit'>
            <a href="#" class="modal-cancel">Cancel</a>
        </div>
        
        <a href="#" id="add-listing-link">Add a listing</a>
        
    </div>

<!-- End For Sale Listings View -->