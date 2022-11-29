import React from "react";
import "./footer.css";

function Footer() {
  return (
    <div className="footer pt-5" id="footer">
      <div className="container">
        <div className="row-footer">
          <div className="col-6 col-sm-6 col-md-4 col-lg-3 mb-5">
            {/* <div className="footer_section">
              <h4>Links</h4>
              <ul>
                <li>
                  <a href="#">Home</a>
                </li>
                <li>
                  <a href="#">Docs</a>
                </li>
                <li>
                  <a href="#">Examples</a>
                </li>
                <li>
                  <a href="#">Icons</a>
                </li>
                <li>
                  <a href="#">Themes</a>
                </li>
                <li>
                  <a href="#">Blog</a>
                </li>
                <li>
                  <a href="#">Swag Store</a>
                </li>
              </ul>
            </div> */}
          </div>
          <div className="col-6 col-sm-6 col-md-4 col-lg-3 mb-5">
            {/* <div className="footer_section">
              <h4>Guides</h4>
              <ul>
                <li>
                  <a href="#">Getting started</a>
                </li>
                <li>
                  <a href="#">Starter template</a>
                </li>
                <li>
                  <a href="#">Webpack</a>
                </li>
                <li>
                  <a href="#">Parcel</a>
                </li>
                <li>
                  <a href="#">Vite</a>
                </li>
              </ul>
            </div> */}
          </div>
          <div className="col-6 col-sm-6 col-md-4 col-lg-3 mb-5">
            {/* <div className="footer_section">
              <h4>Projects</h4>
              <ul>
                <li>
                  <a href="#">Bootstrap 5</a>
                </li>
                <li>
                  <a href="#">Bootstrap 4</a>
                </li>
                <li>
                  <a href="#">Icons</a>
                </li>
                <li>
                  <a href="#">RFS</a>
                </li>
                <li>
                  <a href="#">npm starter</a>
                </li>
              </ul>
            </div> */}
          </div>
          <div className="col-12 col-sm-6 col-md-12 col-lg-3 mb-5">
            <div className="row bottom">
              <div className="col-sm-12 col-md-6 col-lg-12 footer_section footer_section_contact">
                <div className="search"></div>
              </div>
              <div className="col-sm-12 col-md-6 col-lg-12 social_media">
                <h4>Contact Us</h4>
                <ul>
                  <li>
                    <a href="https://www.facebook.com/profile.php?id=100087870436853&notif_id=1669242275506645&notif_t=profile_plus_admin_invite&ref=notif">
                      <i className="fab fa-facebook-f"></i>
                    </a>
                  </li>
                  <li>
                    <a href="tel:+1 (516) 559-2559">
                      <i className="fa fa-phone"></i>
                    </a>
                  </li>

                  <li>
                    <a href="https://instagram.com/doctorsdigitalmarket?igshid=YmMyMTA2M2Y=">
                      <i className="fab fa-instagram"></i>
                    </a>
                  </li>
                  <li>
                    <a href="mailto:info@doctorsdigitalmarket.com">
                      <i class="fa-solid fa-envelope"></i>
                    </a>
                  </li>
                </ul>
              </div>
              <div className="copy">
                <p class="mb-md-0">
                  ©
                  <a class="text-white border-bottom" href="#">
                    Doctors Digital Marketing
                  </a>
                  . All Rights Reserved.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default Footer;
