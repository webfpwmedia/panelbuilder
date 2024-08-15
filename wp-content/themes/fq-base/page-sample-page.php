<?php
/**
 * Basic styles testing page
 * @package FQ_Bones_Theme_Parent
 */
?>

<?php get_header(); ?>

<main class="page-body" style="margin: 0 auto; max-width: 900px;">

	<h1>Base styles</h1>
	<div class="typography-elements entry-body">
		<h2>Typography</h2>
		<h1>This is an H1 heading</h1>
		<p><strong>Paragraph One</strong> &#8211; Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#8217;s standard dummy text ever since the 1500s, when <em>an unknown printer (emphasized text)</em> took a galley of type and scrambled it to make a type specimen book.</p>
		<blockquote>
			<p>This is a blockquote style example. It stands out, but is awesome anyway and it's something somebody else said worth mentioning.</p>
			<cite>-- Some Guy, Some Organization</cite>
		</blockquote>
		<p><strong>This is a strong lead-in:</strong> Lorem Ipsum is simply dummy text of the <a href="#">we interrupt this lorem ipsum for a link, aka anchor text</a> printing and typesetting industry. Lorem Ipsum has been the industry&#8217;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
		<p>And, hey, <strong>Font Awesome is working</strong> if you see this peace sign: <i class="fab fa-angellist"></i><i class="fas fa-angle-double-right"></i></p>
		<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#8217;s standard dummy text ever since the 1500s, when an unknown printer <em>(we interrupt this sentence for some emphasized text)</em> took a galley of type and scrambled it to make a type specimen book.</p>
		<h2>Heading 2 goes says hey</h2>
		<p>And not it is time to start an ordered list:</p>
		<ol>
			<li>Wake up</li>
			<li>Eat Breakfast</li>
			<li>Go to work</li>
			<li>Have coffee</li>
		</ol>
		<p>And then we bring along an unordered list:</p>
		<ul>
			<li>Coffee</li>
			<li>Tea</li>
			<li>Milk</li>
			<li>Bourbon</li>
		</ul>
		<h3 class="square-sm">Heading 3</h3>
		<p>Lorem ipsum dolor sit amet, test link adipiscing elit. Nullam dignissim convallis est. Quisque aliquam. Donec faucibus. Nunc iaculis suscipit dui.</p>
		<p>Nam sit amet sem. Aliquam libero nisi, imperdiet at, tincidunt nec, gravida vehicula, nisl. Praesent mattis, massa quis luctus fermentum, turpis mi volutpat justo, eu volutpat enim diam eget metus. Maecenas ornare tortor. Donec sed tellus eget sapien fringilla nonummy.</p>
		<h4>Heading 4 get smaller yo</h4>
		<p>Lorem ipsum dolor sit amet, test link adipiscing elit. Nullam dignissim convallis est. Quisque aliquam. Donec faucibus. Nunc iaculis suscipit dui. Nam sit amet sem. Aliquam libero nisi, imperdiet at, tincidunt nec, gravida vehicula, nisl. Praesent mattis, massa quis luctus fermentum, turpis mi volutpat justo, eu volutpat enim diam eget metus. Maecenas ornare tortor. Donec sed tellus eget sapien fringilla nonummy.</p>
		<h5>Heading 5 is go-go</h5>
		<p>Lorem ipsum dolor sit amet, test link adipiscing elit. Nullam dignissim convallis est. Quisque aliquam. Donec faucibus. Nunc iaculis suscipit dui. Nam sit amet sem. Aliquam libero nisi, imperdiet at, tincidunt nec, gravida vehicula, nisl. Praesent mattis, massa quis luctus fermentum, turpis mi volutpat justo, eu volutpat enim diam eget metus. Maecenas ornare tortor. Donec sed tellus eget sapien fringilla nonummy.</p>
		<h6>Heading 6 is teeny tiny</h6>
		<p>Lorem ipsum dolor sit amet, test link adipiscing elit. Nullam dignissim convallis est. Quisque aliquam. Donec faucibus. Nunc iaculis suscipit dui. Nam sit amet sem. Aliquam libero nisi, imperdiet at, tincidunt nec, gravida vehicula, nisl. Praesent mattis, massa quis luctus fermentum, turpis mi volutpat justo, eu volutpat enim diam eget metus. Maecenas ornare tortor. Donec sed tellus eget sapien fringilla nonummy.</p>
		<p>And just below this text is an hr rule element</p>
		<hr />
	</div><!-- typography-elements -->

	<div class="color-elements">
		<h2>Colors</h2>

		<style media="screen">
			.color-block {
				height: 150px;
				width: 100%;
				border: 1px solid gray;
			}
			.color-element {
				width: 150px;
			}
			.color-section {
				display: flex;
				flex-wrap: wrap;
			}
		</style>
		<h3>Grays</h3>
		<div class="color-section">
			<div class="color-element">
				<div class="color-block has-black-background-color"></div>
				<p>Black</p>
			</div>
			<div class="color-element">
				<div class="color-block has-gray1-background-color"></div>
				<p>Gray 1</p>
			</div>
			<div class="color-element">
				<div class="color-block has-gray2-background-color"></div>
				<p>Gray 2</p>
			</div>
			<div class="color-element">
				<div class="color-block has-gray3-background-color"></div>
				<p>Gray 3</p>
			</div>
			<div class="color-element">
				<div class="color-block has-gray4-background-color"></div>
				<p>Gray 4</p>
			</div>
			<div class="color-element">
				<div class="color-block has-gray5-background-color"></div>
				<p>Gray 5</p>
			</div>
		</div>
		<h3>Beiges</h3>
		<div class="color-section">
			<div class="color-element">
				<div class="color-block has-beige-background-color"></div>
				<p>Beige</p>
			</div>
		</div>
		<h3>Brand Colors</h3>
		<div class="color-section">
			<div class="color-element">
				<div class="color-block has-primary-background-color"></div>
				<p>Primary</p>
			</div>
			<div class="color-element">
				<div class="color-block has-primary-light-background-color"></div>
				<p>Primary light</p>
			</div>
			<div class="color-element">
				<div class="color-block has-primary-dark-background-color"></div>
				<p>Primary dark</p>
			</div>
		</div>
	</div>

	<h2>Some spinners from FontAwesome</h2>

	<div class="spinner-example processing-spinner">
		Pulse: <i class="far fa-spinner fa-pulse"></i>
		Spin: <i class="fal fa-asterisk fa-spin"></i>
	</div>

	<div class="form-elements">
		<h2>Forms</h2>

		  <form action="#" method="post" enctype="multipart/form-data" onsubmit="return false">

				<fieldset>
					<legend>Login stuff</legend>
					<label for="exampleInputEmail1">Email address</label>
					<input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
					<label for="exampleInputPassword1">Password</label>
					<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
					<input type="checkbox" class="form-check-input" id="exampleCheck1">
					<label class="form-check-label" for="exampleCheck1">Check me out</label>
				</fieldset>

				<fieldset>
					<legend>A select element</legend>
					<label for="exampleFormControlSelect1">Standard select</label>
					<select>
						<optgroup>
							<option selected>-- your favorite Beatle --</option>
							<option value="john">John</option>
							<option value="paul">Paul</option>
							<option value="george">George</option>
							<option value="ringo">Ringo</option>
						</optgroup>
					</select>
				</fieldset>

				<fieldset>
					<legend>Radio buttons</legend>
					<div class="radio-button">
						<input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
						<label class="form-check-label" for="exampleRadios1">Default radio</label>
					</div>
					<div class="radio-button">
						<input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
						<label class="form-check-label" for="exampleRadios2">Second default radio</label>
					</div>
					<div class="radio-button">
						<input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="option3" disabled>
						<label class="form-check-label" for="exampleRadios3">Disabled radio</label>
					</div>
				</fieldset>

				<fieldset>
					<legend>Checkboxes</legend>
					<div class="checkbox">
						<input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
						<label class="form-check-label" for="inlineCheckbox1">1</label>
					</div>
					<div class="checkbox">
						<input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
						<label class="form-check-label" for="inlineCheckbox2">2</label>
					</div>
					<div class="checkbox">
						<input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3" disabled>
						<label class="form-check-label" for="inlineCheckbox3">3 (disabled)</label>
					</div>
				</fieldset>

				<fieldset>
					<label for="exampleFormControlSelect1">Some text in here</label>
					<textarea>Placeholder here ...</textarea>
				</fieldset>

				<fieldset>
					<legend>Some buttons (call to action, secondary & neutral)</legend>
					<input style="margin-right:.5em;" class="" type="submit" value="Buy Now!" />
					<button style="margin-right:.5em;" type="submit" class="hollow">Learn More</button>
					<button style="margin-right:.5em;" type="submit" class="neutral">Cancel</button>
				</fieldset>
		  </form>
	</div><!-- .form-elements -->

	<h2>Tables</h2>

	<div class="table-elements">
		<table>
			<thead>
				<tr>
					<th>
						URL
					</th>
					<th>
						Email
					</th>
					<th>
						Text
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						you.com
					</td>
					<td>
						you@you.com
					</td>
					<td>
						hey, hey
					</td>
				</tr>
				<tr>
					<td>
						me.com
					</td>
					<td>
						me@me.com
					</td>
					<td>
						hi, hi
					</td>
				</tr>
				<tr>
					<td>
						me.com
					</td>
					<td>
						me@me.com
					</td>
					<td>
						hi, hi
					</td>
				</tr>
			</tbody>
		</table>
	</div><!-- .table-elements -->

</main><!-- #main -->

<?php get_footer(); ?>
