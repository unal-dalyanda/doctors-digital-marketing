import React from "react";
import "./button.css";

const Button = ({ buttonData, href }) => {
  return (
    <a className="slider-button" href={href}>
      {buttonData.buttonText}{" "}
    </a>
  );
};

export default Button;
