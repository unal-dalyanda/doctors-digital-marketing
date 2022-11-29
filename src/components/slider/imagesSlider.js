import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
import React from "react";
import "./imageSlider.css";
import Button from "../button/button";
import { buttonData } from "../../data/buttonData";

import Slider from "react-slick";

const ImagesSlider = ({ imagesdata }) => {
  // const r = imagesdata.filter((elem) =>
  //   buttonData.find(({ id }) => elem.id === id)
  // );
  // console.log(r, "id");

  //console.log(imagesdata);

  //console.log(images);
  const settings = {
    infinite: true,
    dots: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    lazyLoad: true,
    autoplay: true,
    autoplaySpeed: 2500,
  };
  return (
    <>
      <div className="tag">{/* <h1>Image Galery</h1> */}</div>

      <div className="imgSlider" id="#about-us">
        <Slider {...settings}>
          {imagesdata.map((imagesdata) => (
            <div className="slider-container" key={imagesdata.id}>
              <>
                <div className="slider-text">
                  <div className="header-container">
                    <h1 className="header-one"> {imagesdata.header1}</h1>
                    <h1 className="header-two"> {imagesdata.header2}</h1>
                    <h1 className="header-three"> {imagesdata.header3}</h1>
                  </div>

                  <p className="slider-paragraph">{imagesdata.paragraph}</p>
                  <div class="ust">
                    {buttonData
                      .filter(
                        (buttonData) => buttonData.id == imagesdata.buttonId
                      )
                      .map((buttonText) => (
                        <Button
                          buttonData={buttonText}
                          href={imagesdata.href}
                        />
                      ))}
                  </div>
                </div>
              </>

              <>
                <div className="img-container">
                  <img
                    className="slide-img"
                    src={imagesdata.imageUrl}
                    alt={imagesdata.alt}
                  />
                  <div className="circle-one"></div>
                  <div className="circle-two"></div>
                </div>
              </>
              <div class="alt">
                {buttonData
                  .filter((buttonData) => buttonData.id == imagesdata.buttonId)
                  .map((buttonText) => (
                    <Button buttonData={buttonText} href={imagesdata.href} />
                  ))}
              </div>
            </div>
          ))}
        </Slider>
      </div>
    </>
  );
};

export default ImagesSlider;
