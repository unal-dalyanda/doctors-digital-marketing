import React from "react";
import "./imageText.css";
// import IMG from "../../img/about-us.avif";

function ImageText() {
  return (
    <div>
      {" "}
      <div className="slider-container image-text" id="about-us">
        <>
          <div className="slider-text align-text">
            <div className="header-container">
              <h2 className="header-one"> About Us</h2>
            </div>

            <p className="slider-paragraph">
              Using our expertise in the field of health, we are working to make
              your business more efficient by creating solutions for Web design,
              Seo, Social media management and all your digital needs. Our team
              can create tailor-made solutions for your business in Digital
              Marketing, so that your digital assets such as your website and
              social media accounts meet more relevant people locally or
              anywhere in the world. We guarantee success with our works and
              references we have carried out from the past to the present.
            </p>
          </div>
        </>

        <>
          <div className="img-container">
            <img
              className="slide-img"
              src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80"
              alt=""
            />
            <div className="circle-one"></div>
            <div className="circle-two"></div>
          </div>
        </>
      </div>
    </div>
  );
}

export default ImageText;
