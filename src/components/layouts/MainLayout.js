import React from "react";
import Navbar from "../navbar/Navbar";
import Footer from "../footer/footer";
import { Outlet } from "react-router-dom";
import Faq from "../faq/faq";
import { faqData } from "../../data/faqData.js";

function MainLayout() {
  //console.log(faqData.length);

  return (
    <>
      <Navbar />

      <div className="container">
        <Outlet />
      </div>

      <Faq />

      <Footer />
    </>
  );
}

export default MainLayout;
