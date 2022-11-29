import React from "react";
import { blogData } from "../../data/blogData";
import { Link } from "react-router-dom";
import "./blog.css";
import "../button/button.css";


function Blog() {
  return (
    <>
      <div className="card-blog-container" id="blogs">
        {blogData.map((item) => (
          <div className="blog-wrapper" id={item.header.split(' ').join("") === "SocialMediaManagement" ? "SocialMedia" : item.header.split(' ').join("")}>
            <div className="card-blog" key={item.id}>
              <div className="card-blog-image">
                <img src={item.imgUrl} alt={item.imgAlt} />
              </div>
              <div className="content">
                <h2 className="blog-h2"> {item.header} </h2>
                <p>
                  {item.content}
                  <Link to={`/blogs/${item.id}`}>
                    <button> {item.buttonText} </button>
                  </Link>
                </p>
              </div>
            </div>
          </div>
        ))}
      </div>
    </>
  );
}

export default Blog;
