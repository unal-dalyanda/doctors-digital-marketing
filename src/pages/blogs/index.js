import React, { useEffect, useState } from "react";
import Blog from "../../components/blog/blog";
import "./style.css";
import { Helmet } from "react-helmet";


function Blogs() {
  return (
    <>
          <Helmet>
        <title>Blogs</title>
        <meta
          name="description"
          content="Doctors Digital Marketing Blogs"
        />
      </Helmet>
      <Blog />
    </>
  );
}

export default Blogs;
