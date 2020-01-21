<template>
  <nav class="navbar">
    <div class="container">
      <div style="display:flex;justify-content:space-between;align-items: center;">
        <div>
          <nuxt-link to="/">
            <img
              src="~static/logo.png"
              style="height: 60px;width: 100%;object-fit: contain;padding:7px 0;object-position: left;"
            />
          </nuxt-link>
        </div>
        <div style="display:flex;">
        <div style="display: flex;flex-direction:column;justify-content: center;">
          <div style="display:flex;align-items:baseline;white-space: nowrap;">
            <p class="hide-on-small-only" style="font-size:13px;color:white;padding-right: 20px;">Call For Unpublished Cheap Flight Deals </p>
          </div>
        </div>
        <div style="display: flex;flex-direction:column;justify-content: center;">
          <div style="display:flex;align-items:baseline;white-space: nowrap;">
            <img style="height:12px;padding-right:10px" src="~static/call-answer.svg" /> <a style="color:white" class="telephone" href="tel:+1-888-220-3565">+1-888-220-3565</a>
          </div>
          <span style="font-size:12px;text-align:right">Toll free – 24 X 7</span>
        </div>
      </div>
      </div>
    </div>
  </nav>
</template>