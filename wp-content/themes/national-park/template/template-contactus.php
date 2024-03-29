<?php
/**
 * Template Name: Contact Us Page
 *
 * Custom template for the Contact Us page.
 *
 * @version 1.0.0
 * @package npx
 */
get_header();

$default_cover_img        = NPX_THEME_URI . '/dist/assets/images/contatc-us-img.png';
$social_media_information = get_field( 'social_information', 'option' );
$contact_us_image         = ! empty( get_field( 'contact_us_image', 'option' ) ) ? get_field( 'contact_us_image', 'option' ) : $default_cover_img;
$contact_details          = ! empty( get_field( 'contact_details', 'option', false ) ) ? get_field( 'contact_details', 'option', false ) : '';
?>
<main>
	<div class="contactus-container">
	
		<?php get_template_part( 'template-parts/page', 'introduction' ); ?>
	
		<div class="container">
			<h2 class="title-curve black"><?php echo esc_html( 'Contact Form' ); ?></h2>
			<div class="contact-form-wrapper">
				<div class="contact-left">
					<form class="inquiry-form">
						<div class="form-group">
							<label for="name"><?php echo esc_html( 'Name' ); ?></label>
							<input type="text" class="form-field inquiry-name" name="name" placeholder="Enter your full name" />
							<span class="error" id="name-error"></span>
						</div>
						<div class="form-group">
							<label for="email"><?php echo esc_html( 'Email Address' ); ?></label>
							<input type="text" class="form-field inquiry-email" name="email" placeholder="Enter your email address" />
						</div>
						<div class="form-group">
							<label for="phone"><?php echo esc_html( 'Phone Number' ); ?></label>
							
							<div class="phone-number-wrapper">							
								
								<div class="phone-number-left">
									<!-- <input type="text" class="inquiry-country" placeholder="+91" />									 -->
									<div class="select-dropdown">
										<div data-value="+91" class="select-dropdown__button inquiry-country">
											<span><?php echo esc_html( '+91' ); ?></span>
											<i class="arrow"></i>
										</div>
										<ul class="country_dropdown_list select-dropdown__list">
											<li data-value="1" class="select-dropdown__list-item">+1</li>
											<li data-value="7" class="select-dropdown__list-item">+7</li>
											<li data-value="20" class="select-dropdown__list-item">+20</li>
											<li data-value="27" class="select-dropdown__list-item">+27</li>
											<li data-value="30" class="select-dropdown__list-item">+30</li>
											<li data-value="31" class="select-dropdown__list-item">+31</li>
											<li data-value="32" class="select-dropdown__list-item">+32</li>
											<li data-value="33" class="select-dropdown__list-item">+33</li>
											<li data-value="34" class="select-dropdown__list-item">+34</li>
											<li data-value="36" class="select-dropdown__list-item">+36</li>
											<li data-value="39" class="select-dropdown__list-item">+39</li>
											<li data-value="40" class="select-dropdown__list-item">+40</li>
											<li data-value="41" class="select-dropdown__list-item">+41</li>
											<li data-value="43" class="select-dropdown__list-item">+43</li>
											<li data-value="44" class="select-dropdown__list-item">+44</li>
											<li data-value="45" class="select-dropdown__list-item">+45</li>
											<li data-value="46" class="select-dropdown__list-item">+46</li>
											<li data-value="47" class="select-dropdown__list-item">+47</li>
											<li data-value="48" class="select-dropdown__list-item">+48</li>
											<li data-value="49" class="select-dropdown__list-item">+49</li>
											<li data-value="51" class="select-dropdown__list-item">+51</li>
											<li data-value="52" class="select-dropdown__list-item">+52</li>
											<li data-value="53" class="select-dropdown__list-item">+53</li>
											<li data-value="54" class="select-dropdown__list-item">+54</li>
											<li data-value="55" class="select-dropdown__list-item">+55</li>
											<li data-value="56" class="select-dropdown__list-item">+56</li>
											<li data-value="57" class="select-dropdown__list-item">+57</li>
											<li data-value="58" class="select-dropdown__list-item">+58</li>
											<li data-value="60" class="select-dropdown__list-item">+60</li>
											<li data-value="61" class="select-dropdown__list-item">+61</li>
											<li data-value="62" class="select-dropdown__list-item">+62</li>
											<li data-value="63" class="select-dropdown__list-item">+63</li>
											<li data-value="64" class="select-dropdown__list-item">+64</li>
											<li data-value="65" class="select-dropdown__list-item">+65</li>
											<li data-value="66" class="select-dropdown__list-item">+66</li>
											<li data-value="81" class="select-dropdown__list-item">+81</li>
											<li data-value="82" class="select-dropdown__list-item">+82</li>
											<li data-value="84" class="select-dropdown__list-item">+84</li>
											<li data-value="86" class="select-dropdown__list-item">+86</li>
											<li data-value="90" class="select-dropdown__list-item">+90</li>
											<li data-value="91" class="select-dropdown__list-item">+91</li>
											<li data-value="92" class="select-dropdown__list-item">+92</li>
											<li data-value="93" class="select-dropdown__list-item">+93</li>
											<li data-value="94" class="select-dropdown__list-item">+94</li>
											<li data-value="95" class="select-dropdown__list-item">+95</li>
											<li data-value="98" class="select-dropdown__list-item">+98</li>
											<li data-value="211" class="select-dropdown__list-item">+211</li>
											<li data-value="212" class="select-dropdown__list-item">+212</li>
											<li data-value="213" class="select-dropdown__list-item">+213</li>
											<li data-value="216" class="select-dropdown__list-item">+216</li>
											<li data-value="218" class="select-dropdown__list-item">+218</li>
											<li data-value="220" class="select-dropdown__list-item">+220</li>
											<li data-value="221" class="select-dropdown__list-item">+221</li>
											<li data-value="222" class="select-dropdown__list-item">+357</li>
											<li data-value="223" class="select-dropdown__list-item">+223</li>
											<li data-value="224" class="select-dropdown__list-item">+224</li>
											<li data-value="225" class="select-dropdown__list-item">+225</li>
											<li data-value="226" class="select-dropdown__list-item">+226</li>
											<li data-value="227" class="select-dropdown__list-item">+227</li>
											<li data-value="228" class="select-dropdown__list-item">+228</li>
											<li data-value="229" class="select-dropdown__list-item">+229</li>
											<li data-value="230" class="select-dropdown__list-item">+230</li>
											<li data-value="231" class="select-dropdown__list-item">+231</li>
											<li data-value="232" class="select-dropdown__list-item">+232</li>
											<li data-value="233" class="select-dropdown__list-item">+233</li>
											<li data-value="234" class="select-dropdown__list-item">+234</li>
											<li data-value="235" class="select-dropdown__list-item">+235</li>
											<li data-value="236" class="select-dropdown__list-item">+236</li>
											<li data-value="237" class="select-dropdown__list-item">+237</li>
											<li data-value="238" class="select-dropdown__list-item">+238</li>
											<li data-value="239" class="select-dropdown__list-item">+239</li>
											<li data-value="240" class="select-dropdown__list-item">+240</li>
											<li data-value="241" class="select-dropdown__list-item">+241</li>
											<li data-value="242" class="select-dropdown__list-item">+242</li>
											<li data-value="243" class="select-dropdown__list-item">+243</li>
											<li data-value="244" class="select-dropdown__list-item">+244</li>
											<li data-value="245" class="select-dropdown__list-item">+245</li>
											<li data-value="246" class="select-dropdown__list-item">+246</li>
											<li data-value="248" class="select-dropdown__list-item">+248</li>
											<li data-value="249" class="select-dropdown__list-item">+249</li>
											<li data-value="250" class="select-dropdown__list-item">+250</li>
											<li data-value="251" class="select-dropdown__list-item">+251</li>
											<li data-value="252" class="select-dropdown__list-item">+252</li>
											<li data-value="253" class="select-dropdown__list-item">+253</li>
											<li data-value="254" class="select-dropdown__list-item">+254</li>
											<li data-value="255" class="select-dropdown__list-item">+255</li>
											<li data-value="256" class="select-dropdown__list-item">+256</li>
											<li data-value="257" class="select-dropdown__list-item">+257</li>
											<li data-value="258" class="select-dropdown__list-item">+258</li>
											<li data-value="260" class="select-dropdown__list-item">+260</li>
											<li data-value="261" class="select-dropdown__list-item">+261</li>
											<li data-value="262" class="select-dropdown__list-item">+262</li>
											<li data-value="263" class="select-dropdown__list-item">+263</li>
											<li data-value="264" class="select-dropdown__list-item">+264</li>
											<li data-value="265" class="select-dropdown__list-item">+265</li>
											<li data-value="266" class="select-dropdown__list-item">+266</li>
											<li data-value="267" class="select-dropdown__list-item">+267</li>
											<li data-value="268" class="select-dropdown__list-item">+268</li>
											<li data-value="269" class="select-dropdown__list-item">+269</li>
											<li data-value="290" class="select-dropdown__list-item">+290</li>
											<li data-value="291" class="select-dropdown__list-item">+291</li>
											<li data-value="297" class="select-dropdown__list-item">+297</li>
											<li data-value="298" class="select-dropdown__list-item">+298</li>
											<li data-value="299" class="select-dropdown__list-item">+299</li>
											<li data-value="350" class="select-dropdown__list-item">+350</li>
											<li data-value="351" class="select-dropdown__list-item">+351</li>
											<li data-value="352" class="select-dropdown__list-item">+352</li>
											<li data-value="353" class="select-dropdown__list-item">+353</li>
											<li data-value="354" class="select-dropdown__list-item">+354</li>
											<li data-value="355" class="select-dropdown__list-item">+355</li>
											<li data-value="356" class="select-dropdown__list-item">+356</li>
											<li data-value="357" class="select-dropdown__list-item">+357</li>
											<li data-value="358" class="select-dropdown__list-item">+358</li>
											<li data-value="359" class="select-dropdown__list-item">+359</li>
											<li data-value="370" class="select-dropdown__list-item">+370</li>
											<li data-value="371" class="select-dropdown__list-item">+371</li>
											<li data-value="372" class="select-dropdown__list-item">+372</li>
											<li data-value="373" class="select-dropdown__list-item">+373</li>
											<li data-value="374" class="select-dropdown__list-item">+374</li>
											<li data-value="375" class="select-dropdown__list-item">+375</li>
											<li data-value="376" class="select-dropdown__list-item">+376</li>
											<li data-value="377" class="select-dropdown__list-item">+377</li>
											<li data-value="378" class="select-dropdown__list-item">+378</li>
											<li data-value="379" class="select-dropdown__list-item">+379</li>
											<li data-value="380" class="select-dropdown__list-item">+380</li>
											<li data-value="381" class="select-dropdown__list-item">+381</li>
											<li data-value="382" class="select-dropdown__list-item">+382</li>
											<li data-value="383" class="select-dropdown__list-item">+383</li>
											<li data-value="385" class="select-dropdown__list-item">+385</li>
											<li data-value="386" class="select-dropdown__list-item">+356</li>
											<li data-value="387" class="select-dropdown__list-item">+387</li>
											<li data-value="389" class="select-dropdown__list-item">+389</li>
											<li data-value="420" class="select-dropdown__list-item">+420</li>
											<li data-value="421" class="select-dropdown__list-item">+421</li>
											<li data-value="423" class="select-dropdown__list-item">+423</li>
											<li data-value="500" class="select-dropdown__list-item">+500</li>
											<li data-value="501" class="select-dropdown__list-item">+501</li>
											<li data-value="502" class="select-dropdown__list-item">+502</li>
											<li data-value="503" class="select-dropdown__list-item">+503</li>
											<li data-value="504" class="select-dropdown__list-item">+504</li>
											<li data-value="505" class="select-dropdown__list-item">+505</li>
											<li data-value="506" class="select-dropdown__list-item">+506</li>
											<li data-value="507" class="select-dropdown__list-item">+507</li>
											<li data-value="508" class="select-dropdown__list-item">+508</li>
											<li data-value="509" class="select-dropdown__list-item">+509</li>
											<li data-value="590" class="select-dropdown__list-item">+590</li>
											<li data-value="591" class="select-dropdown__list-item">+591</li>
											<li data-value="592" class="select-dropdown__list-item">+592</li>
											<li data-value="593" class="select-dropdown__list-item">+593</li>
											<li data-value="595" class="select-dropdown__list-item">+595</li>
											<li data-value="597" class="select-dropdown__list-item">+597</li>
											<li data-value="598" class="select-dropdown__list-item">+598</li>
											<li data-value="599" class="select-dropdown__list-item">+599</li>
											<li data-value="670" class="select-dropdown__list-item">+670</li>
											<li data-value="672" class="select-dropdown__list-item">+672</li>
											<li data-value="673" class="select-dropdown__list-item">+673</li>
											<li data-value="674" class="select-dropdown__list-item">+674</li>
											<li data-value="675" class="select-dropdown__list-item">+675</li>
											<li data-value="676" class="select-dropdown__list-item">+676</li>
											<li data-value="677" class="select-dropdown__list-item">+677</li>
											<li data-value="678" class="select-dropdown__list-item">+678</li>
											<li data-value="679" class="select-dropdown__list-item">+679</li>
											<li data-value="680" class="select-dropdown__list-item">+680</li>
											<li data-value="681" class="select-dropdown__list-item">+681</li>
											<li data-value="682" class="select-dropdown__list-item">+682</li>
											<li data-value="683" class="select-dropdown__list-item">+683</li>
											<li data-value="685" class="select-dropdown__list-item">+685</li>
											<li data-value="686" class="select-dropdown__list-item">+686</li>
											<li data-value="687" class="select-dropdown__list-item">+687</li>
											<li data-value="688" class="select-dropdown__list-item">+688</li>
											<li data-value="689" class="select-dropdown__list-item">+689</li>
											<li data-value="690" class="select-dropdown__list-item">+690</li>
											<li data-value="691" class="select-dropdown__list-item">+691</li>
											<li data-value="692" class="select-dropdown__list-item">+692</li>
											<li data-value="850" class="select-dropdown__list-item">+850</li>
											<li data-value="852" class="select-dropdown__list-item">+852</li>
											<li data-value="853" class="select-dropdown__list-item">+853</li>
											<li data-value="855" class="select-dropdown__list-item">+855</li>
											<li data-value="856" class="select-dropdown__list-item">+856</li>
											<li data-value="880" class="select-dropdown__list-item">+880</li>
											<li data-value="886" class="select-dropdown__list-item">+886</li>
											<li data-value="960" class="select-dropdown__list-item">+960</li>
											<li data-value="961" class="select-dropdown__list-item">+961</li>
											<li data-value="962" class="select-dropdown__list-item">+962</li>
											<li data-value="963" class="select-dropdown__list-item">+963</li>
											<li data-value="964" class="select-dropdown__list-item">+964</li>
											<li data-value="965" class="select-dropdown__list-item">+965</li>
											<li data-value="966" class="select-dropdown__list-item">+966</li>
											<li data-value="967" class="select-dropdown__list-item">+967</li>
											<li data-value="968" class="select-dropdown__list-item">+968</li>
											<li data-value="970" class="select-dropdown__list-item">+970</li>
											<li data-value="971" class="select-dropdown__list-item">+971</li>
											<li data-value="972" class="select-dropdown__list-item">+972</li>
											<li data-value="973" class="select-dropdown__list-item">+973</li>
											<li data-value="974" class="select-dropdown__list-item">+974</li>
											<li data-value="975" class="select-dropdown__list-item">+975</li>
											<li data-value="976" class="select-dropdown__list-item">+976</li>
											<li data-value="977" class="select-dropdown__list-item">+977</li>
											<li data-value="992" class="select-dropdown__list-item">+992</li>
											<li data-value="993" class="select-dropdown__list-item">+993</li>
											<li data-value="994" class="select-dropdown__list-item">+994</li>
											<li data-value="995" class="select-dropdown__list-item">+995</li>
											<li data-value="996" class="select-dropdown__list-item">+996</li>
											<li data-value="998" class="select-dropdown__list-item">+998</li>
										</ul>
									</div>
								</div>							
								
								<div class="phone-number-right">
									<input type="number" class="inquiry-phone" placeholder="Enter your phone number" min="0" />
								</div>
							
							</div>
						
						</div>
						<div class="form-group">
							<label for="reason"><?php echo esc_html( 'Reason' ); ?></label>
							<div class="select-dropdown">
								<div data-value="0" class="select-dropdown__button inquiry-reason">
									<span><?php echo esc_html( 'Select Reason' ); ?></span>
									<i class="arrow"></i>
								</div>
								<ul class="select-dropdown__list">
									<li data-value="newsmedia" class="select-dropdown__list-item"><?php echo esc_html( 'News & Media' ); ?></li>
									<li data-value="experts" class="select-dropdown__list-item"><?php echo esc_html( 'Experts' ); ?></li>
									<li data-value="wildlife" class="select-dropdown__list-item"><?php echo esc_html( 'Wildlife' ); ?></li>
								</ul>
							</div>
						</div>
						<div class="form-group">
							<label for="message"><?php echo esc_html( 'Message' ); ?></label>
							<textarea class="inquiry-message" name="message" cols="30" rows="10" placeholder="Type your message here "></textarea>
						</div>
						<div class="contact-submit">
							<input class="btn btn-lightBrown submit-inquiry" type="submit" value="submit">
							<span id="submit-error" class="error"></span>
							<span class="success-response"></span>
						</div>
						<div class="loader contact-form-loader" style="display:none">
							<img src="<?php echo esc_attr( NPX_THEME_URI . '/dist/assets/images/loader.gif' ); ?>" alt="loader">
						</div>
					</form>
				</div>
				<div class="contact-right">
					<img class="img-cover" src="<?php echo esc_url( $contact_us_image ); ?>" alt="contact-us-img">
				</div>
			</div>

			<div class="contact-footer">
				<h2 class="title-curve black"><?php echo esc_html( 'Contact Details' ); ?></h2>
				<div class="contact-footer-address">
					<?php echo $contact_details; ?>
				</div>
				<div class="social-link-wrapper">
					<?php
					if ( $social_media_information ) {
						?>
							<ul class="social-links">
								<?php
								foreach ( $social_media_information as $detail ) {
									$social_media_img = $detail['icon'];
									$social_media_url = $detail['link'];
									?>
										<li>
											<a href="<?php echo esc_attr( $social_media_url ); ?>">
												<img class="img-cover" src="<?php echo esc_url( $social_media_img ); ?>" alt="">
											</a>
										</li>
									<?php
								}
								?>
							</ul>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</main>
<?php

get_footer();
