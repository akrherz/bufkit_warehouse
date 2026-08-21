<html>
<title>
    What is Apparent Temperature?
</title>

<body>
    <table border="0" align="center">
        <tr>
            <td width="1000">
                <center>
                    <p>
                        <font size=5>
                            <b><u>What is Apparent Temperature?</u></b>
                        </font>
                </center>
                </p>
                <p>
                    Description given in the National Digital Forecast Database (NDFD) Documentation:
                </p>
                <p>
                    <i>
                        <b><u>Apparent Temperature</u>:</b> The perceived temperature in degrees Fahrenheit derived from either a combination of temperature and wind (Wind Chill) or temperature and humidity (Heat Index) for the indicated hour. When the temperature at a particular
                        grid point falls to 50 F or less, wind chill will be used for that point for the Apparent Temperature. When the temperature at a grid point rises above 80 F, the heat index will be used for Apparent Temperature. Between 51 and 80 F, the Apparent Temperature
                        will be the ambient air temperature
                    </i> (<a href="http://www.nws.noaa.gov/ndfd/definitions.htm">Source</a>).
                </p>

                <p>
                    <b><u>Definitions</u>:</b>
                </p>

                <ul>
                    <p>
                        <b><u>Heat Index</u>:</b> High humidity combined with hot temperatures reduce the body's
                        ability to cool itself increasing the risk of heat exhaustion, heat
                        stroke, and other heat related health problems. The Heat Index,
                        also referred to as apparent temperature, is an estimate of the temperature (in °F) that would similarly affect the body at normal
                        humidity (about 20 percent). For example, if the actual temperature is 100°F with 40 percent relative humidity, the heat index is
                        110°F meaning the apparent temperature feels like 110°F to the
                        body
                        </i> (<a href="http://www.campbellsci.com/documents/technical-papers/heatindx.pdf">Source</a>).
                    </p>

                    <ul>
                        <p>
                            <b>Equation:</b>
                        </p>
                        <p>
                            <img src="images/hi_eq.png">
                        </p>
                        <p>
                            where HI = Heat Index, T = Temperature (F), R = Relative Humidity (%),
                            c<sub>1</sub> = -42.38,
                            c<sub>2</sub> = 2.049,
                            c<sub>3</sub> = 10.14,
                            c<sub>4</sub> = -0.2248,
                            <br>
                            c<sub>5</sub> = -0.006838,
                            c<sub>6</sub> = -0.05482,
                            c<sub>7</sub> = 0.001228,
                            c<sub>8</sub> = 0.0008528, and
                            c<sub>9</sub> = -0.00000199
                            </i> (<a href="http://www.srh.noaa.gov/images/ffc/pdf/ta_htindx.PDF">Source</a>).
                            The source states this is accurate to within +/- 1.3 F.
                        </p>
                    </ul>

                    <p>
                        <b><u>Wind Chill</u>:</b> The portion of the cooling of a human body caused by air motion.
                        Air motion accelerates the rate of heat transfer from a human body to the surrounding atmosphere, especially when temperatures are below about 7°C (45°F)
                        </i>(<a href="http://amsglossary.allenpress.com/glossary/search?p=1&query=wind+chill&submit=Search">Source</a>).
                    </p>

                    <ul>
                        <p>
                            <b>Equation:</b>
                        </p>
                        <p>
                            <img src="images/wc_eq.png">
                        </p>
                        <p>
                            where T<sub>wc</sub> = Wind Chill Temperature, T<sub>a</sub> = Atmospheric Temperature (F), and V = Air Speed (mph)
                            </i> (<a href="">Source</a>).
                        </p>
                    </ul>

                </ul>

                <p>
                    The apparent temperature graph on this site uses essentially the same method used in the NDFD calculation, with one exception.
                    I chose to restrict the usage of heat index a bit more by checking if the dew point temperature exceeds 12 C (54 F).
                    If so, <b>and</b> if the air temperature exceeds 80 F, then the heat index is used as the apparent temperature. This is done because errors
                    can start creeping into the results with high temps and low humidities, and with low humidity it technically violates the definition
                    of heat index given above.
                </p>

                <p>
                    An example is provided below, where all three conditions (heat index, wind chill, and air temperature) apply to give the apparent temperature:
                </p>

                <p>
                    <center>
                        <img src="images/apparent_temp_temp.png">
                        <br>
                        Here, the temperature exceeds 80 F and dips below 50 F for a least a few hours during the time series...
                </p>
                <p>
                    <img src="images/apparent_temp_dp.png">
                    <br>
                    While the dew point begins to exceed 54 F toward the end of the time series for some models when the air temperature exceeds 80 F...
                </p>
                <p>
                    <img src="images/apparent_temp_ws.png">
                    <br>
                    Meanwhile, winds are greater than zero while the air temperature dips below 50 F...
                </p>
                <p>
                    <img src="images/apparent_temp.png">
                    <br>
                    The result is the apparent temperature plot. Hope some of you find this useful! Feedback is welcome!
                    </center>
                </p>

            </td>
        </tr>
    </table>
</body>

</html>