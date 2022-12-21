import React from "react";
import "./card.css";
import { servicesData } from "../../data/servicesData";
import Svg from "../../svg/web-analysis-chart-svgrepo-com.svg";

const ServicesCard = () => {
  return (
    <div className="card-bg" key={servicesData.id}>
      <div className="card-container" id="services">
        {servicesData.map((item) => {
          return (
            <a href={item.url}>
              <div key={item.id} id={item.id} className="card">
                <img className="svg" src={item.icon} alt={item.alt} />

                <h2 className="card-header"> {item.header} </h2>
                <p className="card-p"> {item.paragraph} </p>
              </div>
            </a>
          );
        })}
      </div>
    </div>
  );
};

export default ServicesCard;
