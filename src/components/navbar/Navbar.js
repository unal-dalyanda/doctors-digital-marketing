import React, { useState } from "react";

import { navbardata } from "../../data/navbardata";
import "../navbar/navbar.css";
import Logo from "../../logo/logo-png.png";
import Button from "../../components/button/button";
// D:\customers\digital-marketing\public\logo\p1.png

const Navbar = () => {
  const [isNavExpanded, setIsNavExpanded] = useState(false);

  return (
    <>
      <div className="navbar-container">
        <a href="/" className="brand-name">
          <img
            className="logo"
            src={Logo}
            alt="doctors-digital-marketing-logo"
          />
        </a>

        <button
          className="hamburger"
          onClick={() => {
            setIsNavExpanded(!isNavExpanded);
          }}
        >
          {/* icon from Heroicons.com */}
          <span className="material-symbols-outlined">menu</span>
        </button>

        <div
          className={
            isNavExpanded ? "navigation-menu expanded" : "navigation-menu"
          }
        >
          {/* {!location.pathname.includes("/blogs/") ? ( */}

          <ul className="navbar-ul">
            {navbardata.map((item) => {
              return (
                <li
                  className="navbar-li"
                  key={item.id}
                  onClick={() => {
                    setIsNavExpanded(!isNavExpanded);
                  }}
                >
                  <a href={item.url}>
                    {item.label} <span className="pipe">|</span>{" "}
                  </a>
                </li>
              );
            })}
          </ul>
          {/* ) : (
            <Button buttonData={{ buttonText: `Go Home` }} href="/" />
          )} */}
        </div>
      </div>
    </>
  );
};

export default Navbar;
